<?php


namespace frontend\controllers\timetable;

use app\models\newschedule\NewSchedule;
use app\models\settingsnewschedule\SettingsNewSchedule;
use app\models\shifttitle\ShiftTitle;
use app\models\timelesson\TimeLessonSchedule;
use app\models\TypesLesson;
use common\helpers\GroupHelper;
use common\helpers\LanguageHelper;
use common\models\link\PersonInstitutionLink;
use common\models\organization\Classroom;
use common\models\organization\Group;
use common\models\organization\InstitutionDepartment;
use common\models\organization\InstitutionDiscipline;
use common\models\person\Person;
use common\models\Schedule;
use frontend\models\workload\WorkloadTeacher;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;


class NewScheduleController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionScheduleProfile()
    {
        return $this->render('schedule-teacher');
    }

    public function actionGetDepartments()
    {
        $departments = InstitutionDepartment::find()->where(['delete_ts' => null])->asArray()->all();
        return Json::encode($departments);
    }

    public function actionGetGroups($department_id = "", $edu_form = '', $edu_lang = "", $curs = "")
    {
        $groups = Group::find()
            ->andFilterWhere(['department_id' => $department_id, 'education_form' => $edu_form, "language" => $edu_lang, "class" => $curs])
            ->asArray()
            ->all();
        return Json::encode($groups);

    }

    public function actionGetDisciplines($id = null)
    {
        $disciplines = InstitutionDiscipline::find()
            ->filterWhere(['department_id' => $id])
            ->asArray()
            ->all();
        return Json::encode($disciplines);
    }

    public function actionGetEducationForm()
    {
        $eduForm = GroupHelper::getEducationFormList();
        return Json::encode($eduForm);
    }

    public function actionGetEduLangs()
    {
        return Json::encode(LanguageHelper::getLanguageList());
    }

    public function getScheduleGroups()
    {
        $scheduleGroups = Schedule::find()->asArray()->all();
        return Json::encode($scheduleGroups);
    }

    public function actionGetTeachers()
    {
        $teachers = Person::find()
            ->join('LEFT JOIN', 'link.person_institution_link', 'person.id = person_institution_link.person_id')
            ->where([
//                'person_institution_link.institution_id' => Yii::$app->user->identity->institution->id,
                'person.person_type' => 'teacher'
            ])
            ->asArray()
            ->limit(20)
            ->all();
        return Json::encode($teachers);
    }

    public function actionGetTypes()
    {
        $types = TypesLesson::find()->asArray()->all();
        return Json::encode($types);
    }

    public function actionScheduleGroup($group_id)
    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
        $lessons = NewSchedule::find()->filterWhere(['ref_group_id' => $group_id])->asArray()->all();

        return Json::encode($lessons);
    }

    public function actionGetScheduleCard($week, $group, $semester, $teacher_id = '', $shift = '', $discipline = '', $department = '', $edu_lang = '', $edu_form = '')
    {
        $numeratorDenominator = SettingsNewSchedule::find()->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = NewSchedule::find()
            ->joinWith(['discipline' => function ($q) {
                $q->select(['id', 'caption']);
            }])
            ->joinWith(['teacher' => function ($q) {
                $q->select(['id', 'firstname', 'lastname', 'middlename']);
            }])
            ->joinWith(["group" => function ($q) {
                $q->select(['id', 'caption']);
            }])
            ->joinWith(['classroom' => function ($q) {
                $q->select(['id', 'number', 'name']);
            }])
            ->joinWith('types')
            ->andFilterWhere([
                'new_schedule.department_id' => $department,
                'discipline_id' => $discipline,
                'teacher_id' => $teacher_id,
                'semester' => $semester,
                'shift_time' => $shift,
                'week' => $week,
                'ref_group_id' => $group,
                'edu_lang' => $edu_lang,
                'edu_form' => $edu_form,
            ])
            ->asArray()
            ->all();

        $schedule = [];

        // создание пустого массива [7][6] -> [пары][дни недели]
        $this->buildScheduleArray($schedule);

        // заполнение двумерного массива [Номер пары] [день недели]
        $this->assemblySchedule($query, $schedule);

        return $schedule;
    }

    public function actionGetScheduleFromPerson($week, $semester, $shift)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $typePerson = 2; //PersonInstitutionLink::identityTypePerson();
        $personId = 15; //Yii::$app->user->identity->id;

        return NewSchedule::getSchedule($typePerson, $personId, $week, $semester, $shift);
    }

    public function actionGetClassrooms()
    {
        $classroom = Classroom::find()->where(['delete_ts' => null])->asArray()->all();
        return Json::encode($classroom);
    }

    public function actionAddLesson()
    {
        $request = Yii::$app->request;

        // Получить группу чтобы получить язык обучения
        $group_id = $request->getBodyParam('ref_group_id');
        $group = Group::findOne($group_id);
        $lang_id = ArrayHelper::getValue(NewSchedule::getLanguage(), $group->language);

        $model = new NewSchedule();
        $model->load($request->getBodyParams(), '');
        $model->course = (int)$group->class;
        $model->edu_form = (int)$group->education_form;
        $model->edu_lang = (int)$lang_id;

        $arrayRequestParams = [];
        $arrayRequestParams = $request->getBodyParams();


        /**
         * TODO
         * не доделал запрос
        */
        if ($model->save()) {
            $tmp = $model->attributes;
            return Json::encode($tmp);
        }

        return true;

    }

    public function actionDeleteLesson($id)
    {
        $model = NewSchedule::findOne(['id' => $id]);
        if ($model->delete())
            return Json::encode($model->id);

        return true;
    }

    public function actionCopySchedule()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $id = $request->getBodyParam('id');
        $week = $request->getBodyParam('week');
        $semester = $request->getBodyParam('semester');
        $group = $request->getBodyParam('group');


        if ($id == '1') {


            foreach (NewSchedule::find()->where(['ref_group_id' => $group, 'week' => $week, 'semester' => $semester])->each() as $row) {
                $model = new NewSchedule();
                $model->department_id = $row->department_id;
                $model->discipline_id = $row->discipline_id;
                $model->type_id = $row->type_id;
                $model->classroom_id = $row->classroom_id;
                $model->teacher_id = $row->teacher_id;
                $model->ref_group_id = $row->ref_group_id;
                $model->course = $row->course;
                $model->edu_form = $row->edu_form;
                $model->edu_lang = $row->edu_lang;
                $model->semester = $row->semester;
                $model->shift_time = $row->shift_time;
                $model->week = $row->week + 1;
                $model->weekday = $row->weekday;
                $model->couple = $row->couple;

                $model->save();
            }
        } elseif ($id == '2') {
            foreach (NewSchedule::find()->where(['ref_group_id' => $group, 'week' => $week, 'semester' => $semester])->each() as $row) {
                $model = new NewSchedule();
                $model->department_id = $row->department_id;
                $model->discipline_id = $row->discipline_id;
                $model->type_id = $row->type_id;
                $model->classroom_id = $row->classroom_id;
                $model->teacher_id = $row->teacher_id;
                $model->ref_group_id = $row->ref_group_id;
                $model->course = $row->course;
                $model->edu_form = $row->edu_form;
                $model->edu_lang = $row->edu_lang;
                $model->semester = $row->semester + 1;
                $model->shift_time = $row->shift_time;
                $model->week = $row->week;
                $model->weekday = $row->weekday;
                $model->couple = $row->couple;

                $model->save();
            }

        } elseif ($id == '3') {
            $countRows = NewSchedule::find()->where(['ref_group_id' => $group, 'week' => $week, 'semester' => $semester])->count();
        }

        return false;
    }

    public function actionGetRow($id)
    {
        $row = NewSchedule::findOne(['id' => $id]);
        return Json::encode($row);
    }

    /** ToDo
     * проверить
     * изменил запись в модель
    **/
    public function actionModifyCard()
    {
        $request = Yii::$app->request;
        $query = NewSchedule::findOne($request->getBodyParam('id'));
        $query->load($request->getBodyParams(), '');
//        $query->teacher_id = $request->getBodyParam('teacher_id');
//        $query->classroom_id = $request->getBodyParam('classroom_id');
//        $query->discipline_id = $request->getBodyParam('discipline_id');

        if ($query->save()) {
            return false;
        }

        return true;
    }

    public function actionSaveDateSemester()
    {
        $model = SettingsNewSchedule::find()->one();
        $model->setAttributes(Yii::$app->getRequest()->bodyParams);
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        if ($model->save()) {
            return false;
        }
        return true;
    }

    public function actionGetCountWeekSemester($semester_number)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return SettingsNewSchedule::getCountWeekSemester($semester_number);
    }

    public function actionGetSettingsSchedule()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $date = SettingsNewSchedule::find()->select(new Expression('start_first_half_year::date, finish_first_half_year::date, start_second_half_year::date, finish_second_half_year::date'))->one();

        return $date;
    }


    public function actionGetShiftTitle()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (ShiftTitle::find()->exists()) {
            return ShiftTitle::find()->orderBy(['id' => SORT_ASC])->all();
        } else {
            return array_fill(1, 2, []);
        }
    }

    public function actionSetShiftTitle()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        foreach (Yii::$app->getRequest()->bodyParams as $items) {
            foreach ($items as $key => $item) {
                if (ShiftTitle::find()->where(['id' => $item['value']])->exists()) {
                    $model = ShiftTitle::find()->where(['id' => $item['value']])->one();
                    $model->title = $item['label'];
                } else {
                    $model = new ShiftTitle();
                    $model->title = $item['label'];
                }

                if($model->save()){
                    $result[$key] = $model;
                } else {
                    $result[$key] = true;
                }
            }
        }
        return $result;
    }

    public function actionGetDistributedWorkloadOnTeacher()
    {
        $teacher_id = Yii::$app->request->getBodyParam('teacher_id');
        $group_id = Yii::$app->request->getBodyParam('group_id');
        $semester = Yii::$app->request->getBodyParam('semester');
        $discipline_id = Yii::$app->request->getBodyParam('discipline_id');

        Yii::$app->response->format = Response::FORMAT_JSON;

        $quantityCouple = NewSchedule::find()->where(['semester' => $semester, 'discipline_id' => $discipline_id, 'teacher_id' => $teacher_id, 'ref_group_id' => $group_id])->count();

        return $quantityCouple;

    }

    public function buildScheduleArray(&$schedule)
    {
        $schedule = array_fill(1, 7, array_fill(1, 6, array_fill(1, 2, [])));
    }

    public function assemblySchedule($data, &$array)
    {
        foreach ($data as $item) {
            $array[$item['couple']][$item['weekday']][$item['subgroup'] ?? '1'] = $item;
        }
    }
}