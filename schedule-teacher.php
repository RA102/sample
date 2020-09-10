<?php

use yii\helpers\Html;

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<!-- import CSS -->
<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
<!-- Vuetify  -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
<!-- Vuetify  -->

<!-- import Vue before Element -->
<!--<script src="https://unpkg.com/vue/dist/vue.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

<!-- import JavaScript -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

<!-- Moment работа с датами-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment-with-locales.min.js"></script>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.js"></script>

<body class="hold-transition skin-black-light sidebar-mini">

<?php $this->beginBody() ?>

<v-app id="app">
    <div class="card-body skin-white">
        <v-form ref="form" >
            <div class="row">
                <div class="col-md-2 px-1 py-0">
                    <v-select
                            :items="semesters"
                            v-model="filter_semester"
                            item-text="label"
                            item-value="value"
                            label="Семестер"
                            dense
                            outlined
                            clearable
                            :rules="[v => !!v || 'Выберать семестер']"
                            required
                    >
                    </v-select>
                </div>

                <div class="col-md-2 px-1 py-0">
                    <v-select
                            :items="shifts"
                            v-model="filter_shift"
                            item-text="label"
                            item-value="value"
                            label="Смена"
                            :rules="[v => !!v || 'Выберать сменуо']"
                            dense
                            outlined
                            clearable
                    >
                    </v-select>
                </div>

                <div class="col-md-2 px-1 py-0">
                    <v-select
                            :items="weeks"
                            v-model="filter_week"
                            no-data-text="Выбирите семестр"
                            item-text="label"
                            item-value="value"
                            label="Неделя"
                            :rules="[v => !!v || 'Выберать сменуо']"
                            dense
                            outlined
                            clearable
                    >
                    </v-select>
                </div>
            </div>

            <div class="row " style="justify-content: space-between;">
                <v-col
                        class="col-md-4 d-flex"
                        style="justify-content: flex-end"
                >
                    <v-btn
                            @click="getScheduleFromPerson"
                            color="#409EFF"
                            class="ma-2 px-2 white--text"
                            rounded
                            height="40"
                            widht="140"
                    >
                        <v-icon small class="mr-2">el-icon-search</v-icon>
                        Обновить
                    </v-btn>
                </v-col>
            </div>
        </v-form>



        <!--    Расписание в строку массив [пара][день недели]  -->

<!--        <template >-->
<!--            <v-data-table-->
<!--                    :items="schedule"-->
<!--                    :headers="weekdays"-->
<!--                    hide-default-footer-->
<!--                    class="elevation-1"-->
<!--            >-->
<!--                <template #item.index="{ item }">-->
<!--                    {{ schedule.indexOf(item) + 1 }}-->
<!--                </template>-->
<!--                <template #item.item="{item}">-->
<!---->
<!--                    <template v-for="(elem, index) in item">-->
<!--                        <v-card >-->
<!--                            <v-card-title>-->
<!--                                <h4>{{ elem }}</h4>-->
<!--                            </v-card-title>-->
<!--                            <v-divider></v-divider>-->
<!--                        </v-card>-->
<!--                    </template>-->
<!---->
<!--                </template>-->
<!---->
<!--            </v-data-table>-->
<!--        </template>-->

        <v-data-table
                :items="schedule"
                :headers="weekdays"
                hide-default-footer
                fixed-header
                class="elevation-1"
        >
            <template slote="index" slote-scope="props" >
                {{weekdays.value}}
            </template>

            <template #body="{ items, headers }">
                <tbody>
                    <tr v-for="(item, index) in items" class="flex justify-center">
                        <td v-for="(weekday, index) in weekdays">
                            <template></template>
                            <template v-if="item[weekday.value]?.classroom">
                                <v-card
                                        @click="getClick(item[weekday.value])"
                                >
                                    <v-toolbar color="#2979FF" dark>
                                        <div class="col-md-3 p-0">
                                            {{ item[weekday.value]?.classroom?.number }}
                                        </div>
                                        <div class="col-md-9 p-0">
                                            {{ item[weekday.value]?.types?.name }}
                                        </div>
                                    </v-toolbar>
                                    <v-card-subtitle class="text-center">
                                                {{ item[weekday.value]?.teacher?.firstname }} {{ item[weekday.value]?.teacher?.lastname }}
                                    </v-card-subtitle>
                                    <v-card-text class="text-center">
                                        <div>
                                            {{ JSON.parse(item[weekday.value]?.group?.caption).ru}}
                                        </div>
                                        <div>
                                            {{JSON.parse(item[weekday.value]?.discipline?.caption).ru}}
                                        </div>
                                    </v-card-text>
                                    {{item[weekday.value].couple}}
                                </v-card>

                            </template>
                            <template v-else>
                                <v-card @click.stop="handlerCard(index, weekday.value)">
                                    <v-card-title>
                                        <h4></h4>
                                    </v-card-title>
                                    <v-divider></v-divider>
                                </v-card>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </template>



            <template v-slot:no-results>
                NO RESULTS HERE!
            </template>
        </v-data-table>




<!--            <template >-->
<!--                <v-data-table-->
<!--                        :headers="weekdays"-->
<!--                        :items="schedule"-->
<!--                        item-key="index"-->
<!--                        hide-default-footer-->
<!--                        class="elevation-1"-->
<!--                >-->
<!--                    <template #item.index="{ item }">-->
<!--                        {{ schedule.indexOf(item) }}-->
<!--                    </template>-->
<!---->
<!---->
<!--                    <template #item v-slote:item="item">-->
<!---->
<!--                    </template>-->



<!--                    <template >-->
<!--                        <v-container fluid>-->
<!--                            <v-data-iterator-->
<!--                                    :items="{item}"-->
<!--                                    item-key="item.id"-->
<!--                                    hide-default-footer-->
<!--                                    hide-default-header-->
<!--                            >-->
<!--                                <template v-slot:default="props">-->
<!--                                    <v-row >-->
<!--                                        <v-col-->
<!--                                                v-for="(el,index) in props"-->
<!--                                                :key="index"-->
<!--                                                cols="12"-->
<!--                                                sm="6"-->
<!--                                                md="4"-->
<!--                                                lg="3"-->
<!--                                        >-->
<!--                                            <v-card>-->
<!--                                                <v-card-title>-->
<!--                                                    <h4>{{ item }}</h4>-->
<!--                                                </v-card-title>-->
<!--                                                <v-divider></v-divider>-->
<!--                                                <v-list dense>-->
<!--                                                    <v-list-item>-->
<!--                                                        <v-list-item-content>Item:</v-list-item-content>-->
<!--                                                        <v-list-item-content class="align-end">{{el}}-->
<!--                                                        </v-list-item-content>-->
<!--                                                    </v-list-item>-->
<!---->
<!--                                                </v-list>-->
<!--                                            </v-card>-->
<!--                                        </v-col>-->
<!--                                    </v-row>-->
<!--                                </template>-->
<!--                            </v-data-iterator>-->
<!--                        </v-container>-->
<!--                    </template>-->

<!--                </v-data-table>-->
<!--            </template>-->


          <!-- конец таблицы расписания       -->
    </div>

    <pre v-cloak></pre>

</v-app>

<script>
    var startApp = {};
    var init = function() {
        wlAppScheduleFromPerson = new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data() {
                return {
                    current_date: new Date(),
                    currentSemester: null,
                    currentWeek: null,

                    weekdays: [
                        {
                            text: 'Пара',
                            align: 'center',
                            sortable: false,
                            value: 'index',
                            width: '10%',
                        },
                        { text: 'Понедельник', value: '0', align: 'center', width: '15%'},
                        { text: 'Вторник', value: '1', align: 'center', width: '15%'},
                        { text: 'Среда', value: '2', align: 'center', width: '15%'},
                        { text: 'Четверг', value: '3', align: 'center', width: '15%'},
                        { text: 'Пятница', value: '4', align: 'center', width: '15%'},
                        { text: 'Суббота', value: '5', align: 'center', width: '15%'}
                    ],


                    schedule:[
                        [ {}, {}, {}, {}, {}, {} ],
                        [ {}, {}, {}, {}, {}, {} ],
                        [ {}, {}, {}, {}, {}, {} ],
                        [ {}, {}, {}, {}, {}, {} ],
                        [ {}, {}, {}, {}, {}, {} ],
                        [ {}, {}, {}, {}, {}, {} ],
                        [ {}, {}, {}, {}, {}, {} ],
                    ],

                    headers: [
                        {
                            text: 'Dessert (100g serving)',
                            align: 'start',
                            sortable: false,
                            value: 'name',
                        },
                        { text: 'Calories', value: 'calories' },
                        { text: 'Fat (g)', value: 'fat' },
                        { text: 'Carbs (g)', value: 'carbs' },
                        { text: 'Protein (g)', value: 'protein' },
                        { text: 'Iron (%)', value: 'iron' },
                    ],

                    desserts: [
                        {
                            name: 'Frozen Yogurt',
                            calories: 159,
                            fat: 6.0,
                            carbs: 24,
                            protein: 4.0,
                            iron: '1%',
                        },
                        {
                            name: 'Ice cream sandwich',
                            calories: 237,
                            fat: 9.0,
                            carbs: 37,
                            protein: 4.3,
                            iron: '1%',
                        },
                        {
                            name: 'Eclair',
                            calories: 262,
                            fat: 16.0,
                            carbs: 23,
                            protein: 6.0,
                            iron: '7%',
                        },
                    ],

                    semesters: [
                        {value: '1', label: '1-й'},
                        {value: '2', label: '2-й'},
                    ],
                    filter_semester:'',

                    shifts: [],
                    filter_shift:'',

                    weeks: [],
                    filter_week:'',

                    teachers: [],
                    filter_teacher: '',

                    array_dates_weekdays: [],
                }
            },

            mounted: function () {
                this.initAppProc();
            },

            created: function () {

            },

            // beforeUpdated: {
            //
            // },
            //
            // updated: {
            //
            // },

            computed: {

            },

            watch: {
                filter_semester: function() {
                    this.countWeek();
                }

            },

            methods: {
                initAppProc() {
                    this.getTitleShift();
                },

                getClick(item) {
                    console.log(item);
                },

                handlerCard(i, wv) {
                    console.log(i, wv);
                },

                conlog(item) {
                  console.log(item);
                },

                computedDateFormattedMomentjs: (date) => {
                    moment.locale('ru');
                    return date ? moment(date).format('ll') : '';
                },

                // getTeachers() {
                //     axios.get('/timetable/new-schedule/get-teachers')
                //         .then((response) => {console.log(response)})
                //         .catch(error => console.log(error))
                // },

                getTitleShift() {
                    axios.get('/timetable/new-schedule/get-shift-title')
                        .then(function(response) {
                            if(response.status == 200) {
                                wlAppScheduleFromPerson.shifts = $.map(response.data,  (e, key) => {
                                    return {
                                        value: e.id ?? key,
                                        label: e.title ?? `Название смены ${key}`
                                    }
                                })
                            }
                        })
                        .catch(error => console.log(error));
                },

                /**
                 * Перенести расчет кол-во недель в модель для записи в таблицу
                 * (чтобы каждый раз не расчитывать)
                 */
                countWeek() {
                    axios.get('/timetable/new-schedule/get-count-week-semester', {
                        params: {
                            semester_number: wlAppScheduleFromPerson.filter_semester
                        }
                    })
                        .then((response) => {
                            for(let i=1; i <= response.data; i++) {
                                wlAppScheduleFromPerson.weeks.push({ value: i, label: i });
                            }
                        })
                        .catch(error => console.log(error))
                },

                getScheduleFromPerson() {
                    axios.get('/timetable/new-schedule/get-schedule-from-person', {
                        params: {
                            week: wlAppScheduleFromPerson.filter_week,
                            semester: wlAppScheduleFromPerson.filter_semester,
                            shift: wlAppScheduleFromPerson.filter_shift
                        }
                    })
                        .then(function(response) {
                            response.data.forEach(function (item, key, array) {
                                Vue.set(wlAppScheduleFromPerson.schedule[item.couple], item.weekday, item);
                            })
                        })
                        .catch( error => console.log(error))
                },

                fillArrayDateSelectedWeek() {

                },


            }
        })
    }();

</script>

<style>
    hr.v-divider {
        margin-top: 0;
        margin-bottom: 0;
    }

</style>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
