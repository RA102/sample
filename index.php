<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\rup\RupRootsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
<!--<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">-->
<link rel="stylesheet" href="../css/elementindex.css">

<!-- Vuetify  -->
<!--<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">-->
<!--<link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">-->
<!--<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">-->

<link href="../css/roboto.css" rel="stylesheet">
<link href="../css/materialdesignicons.min.css" rel="stylesheet">
<link href="../css/vuetify.min.css" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.js"></script>
<!--<script scr="../js/axios.js"></script>-->

<!-- Moment работа с датами-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment-with-locales.min.js"></script>-->
<script src="../js/moment-with-locales.js"></script>

<!-- Vuetify  -->

<!-- import Vue before Element -->
<!--<script src="https://unpkg.com/vue/dist/vue.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>-->

<script src="../js/vue.js"></script>
<script src="../js/vuetify.js"></script>

<!-- import JavaScript -->
<!--<script src="https://unpkg.com/element-ui/lib/index.js"></script>-->
<!--<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>-->
<script src="../js/ElementIndex.js"></script>
<script src="../js/jquery-2.2.4.min.js"></script>





<body class="hold-transition skin-black-light sidebar-mini">

<?php $this->beginBody() ?>


<v-app id="app">
    <!-- Фильтры -->
    <div class="card-body skin-white">
        <v-form ref="form" v-model="valid" lazy-validation>
            <div class="row">
                <div class="col-md-6 px-1 py-0">
                    <v-select
                        :items="departments"
                        v-model="filter_department"
                        default-value=""
                        item-text="label"
                        item-value="value"
                        label="Кафедра"
                        no-data-text="пусто"
                        dense
                        outlined
                        clearable
                    >
                    </v-select>
                </div>

                <div class="col-md-2 px-1 py-0">
                    <v-select
                        :items="eduforms"
                        v-model="filter_eduform"
                        item-text="label"
                        item-value="value"
                        label="Форма обучения"
                        dense
                        outlined
                        clearable
                    >
                    </v-select>

                </div>

                <div class="col-md-2 px-1 py-0">
                    <v-select
                        :items="edulangs"
                        v-model="filter_edulang"
                        item-text="label"
                        item-value="value"
                        label="Язык обучения"
                        dense
                        outlined
                        clearable
                    >
                    </v-select>
                </div>

                <div class="col-md-2 px-1 py-0">
                    <v-select
                        :items="courselist"
                        v-model="filter_course"
                        item-text="label"
                        item-value="value"
                        label="Курс"
                        dense
                        outlined
                        clearable
                    >
                    </v-select>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6 px-1 py-0">
                    <v-select
                        :items="studentgroups"
                        v-model="filter_studentgroup"
                        item-text="label"
                        item-value="value"
                        label="Группа"
                        no-data-text="пусто"
                        dense
                        outlined
                        clearable
                        :rules="[v => !!v || 'Выберать группу']"
                        required
                    >
                    </v-select>

                </div>

                <div class="col-md-4 px-1 py-0">

                    <v-select
                        :items="teachers"
                        v-model="filter_teacher"
                        item-text="label"
                        item-value="value"
                        label="Преподователь"
                        dense
                        outlined
                        clearable
                    >
                    </v-select>
                </div>

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

            </div>


            <div class="row">

                <div class="col-md-8 px-1 py-0">
                    <v-select
                        :items="disciplines"
                        v-model="filter_discipline"
                        item-text="label"
                        item-value="value"
                        label="Дисциплина"
                        dense
                        outlined
                        clearable
                        flat
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
                        dense
                        outlined
                        clearable
                        :rules="[v => !!v || 'Выберите неделю']"
                        required
                    >
                    </v-select>
                </div>
            </div>

            <div class="row " style="justify-content: space-between;">

                <v-col
                    class="col-md-2"
                >
                    <v-btn
                            @click="modal_settings = true,  getSettingsSchedule"
                            :disabled="modal_loading"
                            :loading="modal_loading"
                            color="#409EFF"
                            class="ma-2 px-2 white--text"
                            rounded
                            elevation="6"
                            height="40"
                            widht="140"
                    >
                        <v-icon small class="mr-2 mdi mdi-cog-outline"></v-icon>
                        Настойки
                    </v-btn>
                </v-col>

                <v-col
                    class="col-md-6 d-flex pl-1"
                    style="align-items: baseline"
                >
<!--                    <v-col-->
<!--                        cols="4"-->
<!--                        v-show="show_copy"-->
<!--                        class="pl-0"-->
<!--                    >-->
<!--                        <v-select-->
<!--                            :items="copy_settings"-->
<!--                            v-model="filter_copy"-->
<!--                            item-text="label"-->
<!--                            item-value="value"-->
<!--                            dense-->
<!--                            outlined-->
<!--                            clearable-->
<!--                        >-->
<!--                        </v-select>-->
<!--                    </v-col>-->
<!---->
<!--                    <v-btn-->
<!--                        v-show="show_copy"-->
<!--                        @click="copySchedule(), modal_loading = true"-->
<!--                        :disabled="modal_loading"-->
<!--                        :loading="modal_loading"-->
<!--                        color="#409EFF"-->
<!--                        class="ma-2 px-2 white--text"-->
<!--                        rounded-->
<!--                        elevation="6"-->
<!--                        height="40"-->
<!--                        widht="140"-->
<!--                    >-->
<!--                        <v-icon small class="mr-2">el-icon-plus</v-icon>-->
<!--                        Копировать-->
<!--                    </v-btn>-->

                </v-col>

                <v-col
                    class="col-md-4 d-flex"
                    style="justify-content: flex-end"
                >
                    <v-btn
                        :disabled="!valid"
                        @click="getSchedule(), computeDate(), fillArrayDateSelectedWeek()"
                        color="#409EFF"
                        class="ma-2 px-2 white--text"
                        rounded
                        elevation="6"
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

        <v-row>
            <v-col
                :cols="1"
                class="text-center separator-line position-relative "
            >
                Пара
            </v-col>
            <v-col
                class="text-center separator-line position-relative"
            >
                Понедельник
                <v-col
                        v-model="array_dates_weekdays[0]"
                >{{computedDateFormattedMomentjs(array_dates_weekdays[0])}}</v-col>
            </v-col>
            <v-col
                class="text-center separator-line position-relative"
            >
                Вторник
                <v-col
                        v-model="array_dates_weekdays[1]"
                >{{computedDateFormattedMomentjs(array_dates_weekdays[1])}}</v-col>
            </v-col>
            <v-col
                class="text-center separator-line position-relative"
            >
                Среда
                <v-col
                        v-model="array_dates_weekdays[2]"
                >{{computedDateFormattedMomentjs(array_dates_weekdays[2])}}</v-col>
            </v-col>
            <v-col
                class="text-center separator-line position-relative"
            >
                Четверг
                <v-col
                        v-model="array_dates_weekdays[3]"
                >{{computedDateFormattedMomentjs(array_dates_weekdays[3])}}</v-col>
            </v-col>
            <v-col
                class="text-center separator-line position-relative"
            >
                Пятница
                <v-col
                        v-model="array_dates_weekdays[4]"
                >{{computedDateFormattedMomentjs(array_dates_weekdays[4])}}</v-col>
            </v-col>
            <v-col
                class="text-center "
            >
                Суббота
                <v-col
                        v-model="array_dates_weekdays[5]"
                >{{computedDateFormattedMomentjs(array_dates_weekdays[5])}}</v-col>
            </v-col>
        </v-row>


        <v-row
            v-for="(items, couple) of tableData"
            :key="couple"
            class="align-items-stretch "
            v-bind:class="{grey: true, 'lighten-2': true}"
            v-bind:couple="couple"
            v-on:click.stop="subgroup_func(couple)"
            ref="couple"
        >
            <v-col
                :cols="1"
                class=""
            >
                <v-card class="" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%">
                    <div class="custom-font text-center" >{{couple}}</div>
                    <div>{{computedTime(couple)}}</div>
                </v-card>
            </v-col>

            <v-col
                v-for="(item_el, weekday) of items"
                style="padding-left: 6px; padding-right: 6px;"
                :key="weekday"
            >
                <template >
                    <v-card
                        v-for="(item , subgroup) of item_el"
                        :id="item.id"
                        :key="item.id"
                        :style="{ padding: '10px', 'margin-bottom': '5px', height: '230px'}"
                        v-bind:class="item.updated_at ? bg_changed : ''"
                        v-bind:couple="couple"
                        v-bind:weekday="weekday"
                        v-bind:subgroup="subgroup"
                    >
                        <template v-if="item.discipline" >
                            <div >
                                <v-card-subtitle
                                        style="display: flex; justify-content: space-between;"
                                        class="text-caption text-uppercase font-weight-black px-0 py-1"
                                >
                                    <v-chip
                                            style="font-size: inherit"
                                            color="orange"
                                            label
                                            outlined
                                            small
                                    >
                                        {{item.classroom.number}}
                                    </v-chip>
                                    <v-chip
                                            style="font-size: inherit"
                                            color="cyan"
                                            label
                                            outlined
                                            small
                                    >
                                        {{item.types.name}}
                                    </v-chip>

                                </v-card-subtitle>
                                    <v-card-subtitle
                                        v-if="item.discipline"

                                        class="text-caption text-capitalize font-weight-black px-0 py-1"
                                    >
                                        <span >{{JSON.parse(item.discipline.caption).ru }}</span>
                                    </v-card-subtitle>


                                <v-card-subtitle
                                        class="text-caption text-capitalize font-weight-black px-0 py-1 black--text"
                                >
                                    {{item.teacher.firstname}} {{item.teacher.lastname}}<br>
                                    {{item.teacher.middlename}}
                                </v-card-subtitle>

                                <v-card-subtitle
                                    class="text-caption text-capitalize font-weight-black px-0 py-1"
                                >
                                    {{JSON.parse(item.group.caption).ru}}
                                </v-card-subtitle>

                            </div>

                            <div class="col pl-1 pr-1 py-0 mt-2">
                                <el-button
                                    round
                                    size="small"
                                    type="warning"
                                    @click="change_card = true, change_info=item, info.weekday=index_weekday"
                                    icon="el-icon-edit"
                                    title="Изменить"
                                    class="white--text"></el-button>

                                <el-button
                                    round
                                    size="small"
                                    type="danger"
                                    @click="info=item, deleteLesson(item.id)"
                                    icon="el-icon-delete"
                                    title="Удалить"
                                    class="pull-right white--text"></el-button>
                            </div>
<!--                            <div class="col offset-4 py-0 py-0">-->
<!--                                <el-button-->
<!--                                        v-bind:couple="couple"-->
<!--                                        v-bind:weekday="weekday"-->
<!--                                        ref="button_plus"-->
<!--                                        type="primary"-->
<!--                                        icon="el-icon-plus"-->
<!--                                        title="Добавить"-->
<!--                                        round-->
<!--                                        size="small"-->
<!--                                >-->
<!--                                </el-button>-->
<!--                            </div>-->
                        </template>

                        <template v-else>
                            <v-row
                                class="align-items-center fill-height">
                                <v-col class="text-center">
                                    <el-button
                                            type="primary"
                                            icon="el-icon-plus"
                                            title="Добавить"
                                            round
                                            @click="modal_show=true, add_lesson_modal=true, info.couple=couple, info.weekday=weekday, info.subgroup=subgroup"
                                    ></el-button>
                                </v-col>
                            </v-row>
                        </template>
                    </v-card>
                </template>
            </v-col>
        </v-row>
    </div>

    <!--  modal addLesson -->
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="modal_show"
                persistent
                max-width="750"
            >
                <v-card>
                    <v-card-title class="headline"></v-card-title>
                    <v-card-text>
                        <v-container>
                            <h3>Добавить урок</h3>

                            <v-row>
                                <v-col
                                    :cols="2"
                                    class="label-center"
                                > Дисциплина
                                </v-col>
                                <v-col
                                    :cols="7"
                                >
                                    <el-select
                                        v-model="filter_discipline"
                                        clearable
                                        placeholder="Выберите"
                                        required
                                        style="width: 100%;"
                                    >
                                        <el-option
                                            v-for="item in disciplines"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                        >
                                        </el-option>
                                    </el-select>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col
                                    :cols="2"
                                    class="label-center"
                                > Тип занятия
                                </v-col>
                                <v-col :cols="7">
                                    <el-select
                                        v-model="filter_type"
                                        clearable
                                        placeholder="Выберите"
                                        required
                                        style="width: 100%;"
                                    >
                                        <el-option
                                            v-for="item in types_lesson"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.id">
                                        </el-option>
                                    </el-select>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col
                                    :cols="2"
                                    class="label-center"
                                >
                                    Под группа
                                </v-col>
                                <v-col
                                    :cols="7"
                                >
                                    <el-select
                                        v-model="filter_subgroup"
                                        clearable
                                        placeholder="Выберите"
                                        style="width: 100%;"
                                        no-data-text="Ничего не найдено"
                                    >
                                        <el-option
                                            v-for="item in subgroups"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.id">
                                        </el-option>
                                    </el-select>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col
                                    :cols="2"
                                    class="label-center"> Преподаватель
                                </v-col>
                                <v-col
                                    :cols="7"
                                >
                                    <el-select v-model="filter_teacher" clearable placeholder="Выберите"
                                               style="width: 100%;">
                                        <el-option
                                            v-for="item in teachers"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                        </el-option>
                                    </el-select>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col
                                    :cols="2"
                                    class="label-center"
                                >
                                    Аудитория
                                </v-col>
                                <v-col
                                    :cols="7"
                                >
                                    <el-select v-model="add_lesson.classroom" clearable placeholder="Выберите"
                                               style="width: 100%;">
                                        <el-option
                                            v-for="item in classrooms"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.id">
                                        </el-option>
                                    </el-select>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col
                                    :cols="2"
                                    class="label-center"

                                >
                                    числитель/знаменатель
                                </v-col>
                                <v-col
                                    :cols="7"
                                >
                                    <el-select
                                        v-model="filter_decimal_number"
                                        v-bind:disabled="!switch_button"
                                        clearable
                                        placeholder="Выберите"
                                        no-data-text="Ничего не найдено"
                                        style="width: 100%;"
                                    >
                                        <el-option
                                            v-for="item in decimal_numbers"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.id">
                                        </el-option>
                                    </el-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            text
                            @click="modal_show=false"
                        >
                            Отмена
                        </v-btn>
                        <v-btn
                            color="primary"
                            text
                            @click="modal_show=false, addLesson()"
                        >
                            Сохранить
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </template>

    <!-- end modal   -->

    <!-- modal change  -->
    <template>
        <div class="text-center">
            <v-dialog
                v-model="change_card"
                width="700"
                padding="50"
            >
                <v-card>
                    <v-tabs
                        v-model="tab"
                        background-color="transparent"
                        color="cyan"
                    >
                        <v-tabs-slider color="yellow"></v-tabs-slider>
                        <v-tab
                            v-for="(tab, i) in tabs"
                            :key="i"
                        >
                            {{ tab.title }}
                        </v-tab>
                    </v-tabs>


                    <!--             Замена преподователя/дисциплины       -->

                    <v-tabs-items v-model="tab">
                        <v-tab-item
                        >
                            <v-card
                                color="basil"
                                flat
                            >
                                <v-card-text>

                                    <v-container>

                                        <!-- Преподаватель-->
                                        <v-row>
                                            <v-row>
                                                <v-col
                                                    :cols="2"
                                                    class="label-center"> Преподаватель
                                                </v-col>
                                                <v-col
                                                    :cols="7"
                                                >
                                                    <h4 v-if="change_info.teacher">{{change_info.teacher.firstname}}
                                                        {{change_info.teacher.lastname}}</h4>
                                                </v-col>
                                            </v-row>
                                        </v-row>

                                        <!-- textfield причина замены-->
                                        <v-row>
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    label="Причина замены"
                                                    outlined
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <!--дисциплина -->
                                        <v-row>
                                            <v-col :cols="2"> Дисциплина
                                            </v-col>
                                            <v-col :cols="7">
                                                <el-select v-model="change_info.discipline_id" clearable
                                                           placeholder="Выберите" style="width: 100%;">
                                                    <el-option
                                                        v-for="item in disciplines"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value"
                                                    >
                                                    </el-option>
                                                </el-select>
                                            </v-col>

                                        </v-row>

                                        <!-- Тип занятия-->
                                        <v-row>
                                            <v-col :cols="2"> Тип занятия
                                            </v-col>
                                            <v-col :cols="7">
                                                <el-select v-model="change_info.type_id" clearable
                                                           placeholder="Выберите" style="width: 100%;">
                                                    <el-option
                                                        v-for="item in types_lesson"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                    </el-option>
                                                </el-select>
                                            </v-col>
                                        </v-row>

                                        <!-- Подгруппа-->
                                        <v-row>
                                            <v-col
                                                :cols="2"
                                                class="label-center"
                                            >
                                                Под группа
                                            </v-col>
                                            <v-col
                                                :cols="7"
                                            >
                                                <el-select
                                                    v-model="filter_subgroup"
                                                    no-data-text="Ничего не найдено"
                                                    clearable placeholder="Выберите"
                                                    style="width: 100%;"
                                                >
                                                    <el-option
                                                        v-for="item in subgroups"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                    </el-option>
                                                </el-select>
                                            </v-col>
                                        </v-row>

                                        <!--  новый преподователь   -->

                                        <v-row>
                                            <v-col
                                                :cols="2"
                                                class="label-center"> Преподаватель
                                            </v-col>
                                            <v-col
                                                :cols="7"
                                            >
                                                <el-select v-model="change_info.teacher_id" clearable
                                                           placeholder="Выберите" style="width: 100%;">
                                                    <el-option
                                                        v-for="item in teachers"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </v-col>
                                        </v-row>

                                        <!-- Аудитория -->
                                        <v-row>
                                            <v-col
                                                :cols="2"
                                                class="label-center"
                                            >
                                                Аудитоория
                                            </v-col>
                                            <v-col
                                                :cols="7"
                                            >
                                                <el-select v-model="change_info.classroom_id" clearable
                                                           placeholder="Выберите" style="width: 100%;">
                                                    <el-option
                                                        v-for="item in classrooms"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                    </el-option>
                                                </el-select>
                                            </v-col>
                                        </v-row>

                                        <!--    Числитель/знаменатель  -->
                                        <v-row>
                                            <v-col
                                                :cols="2"
                                                class="label-center"
                                            >
                                                числитель/знаменатель
                                            </v-col>
                                            <v-col
                                                :cols="7"
                                            >
                                                <el-select v-model="filter_decimal_number" no-data-text="Ничего не найдено" clearable
                                                           placeholder="Выберите" style="width: 100%;">
                                                    <el-option
                                                        v-for="item in decimal_numbers"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                    </el-option>
                                                </el-select>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>

                        <!-- второй таб  замена аудитории-->
                        <v-tab-item>
                            <v-card
                                color="basil"
                                flat
                            >
                                <v-card-text>
                                    <!-- Текущая аудитория-->
                                    <v-container>
                                        <v-row>
                                            <v-row>
                                                <v-col
                                                    :cols="2"
                                                    class="label-center"> Текущая аудитория
                                                </v-col>
                                                <v-col
                                                    :cols="7"
                                                >
                                                    <h4 v-if="change_info.classroom">{{change_info.classroom.name}}</h4>
                                                </v-col>
                                            </v-row>
                                        </v-row>

                                        <!-- textfield причина замены-->
                                        <v-row>
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field
                                                    label="Причина замены"
                                                    outlined
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>


                                        <v-row>
                                            <v-col
                                                :cols="2"
                                                class="label-center"
                                            >
                                                Заменить на
                                            </v-col>
                                            <v-col
                                                :cols="7"
                                            >
                                                <el-select v-model="change_info.classroom_id" clearable
                                                           placeholder="Выберите" style="width: 100%;">
                                                    <el-option
                                                        v-for="item in classrooms"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                    </el-option>
                                                </el-select>
                                            </v-col>
                                        </v-row>
                                    </v-container>

                                </v-card-text>
                            </v-card>
                        </v-tab-item>

                    </v-tabs-items>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <el-button
                            type="primary"
                            round
                            text
                            @click="change_card=false"
                        >
                            Отмена
                        </el-button>
                        <el-button
                            type="primary"
                            round
                            text
                            @click=" modifyCard(change_info)"
                        >
                            Сохранить
                        </el-button>

                    </v-card-actions>
                </v-card>

            </v-dialog>
        </div>
    </template>

    <!-- end change   -->

    <!-- modal_finish_copy-->
    <template>
        <div class="text-center">
            <v-dialog
                v-model="modal_finish_copy"
                width="500"
            >
                <v-card>
                    <v-card-title class="headline grey lighten-2">
                        {{modal_text}}
                    </v-card-title>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            text
                            @click="modal_finish_copy = false"
                        >
                            Ok
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </template>

    <!-- End modal_finish_copy -->

    <!-- modal_loading -->

    <template>
        <div class="text-center">
            <v-dialog
                v-on="on"
                hide-overlay
                persistent
                width="300"
            >
                <v-card
                    color="primary"
                    dark
                >
                    <v-card-text>
                        Please stand by
                        <v-progress-linear
                            indeterminate
                            color="white"
                            class="mb-0"
                        ></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </template>
    <!-- end modal_loading -->

    <!-- modal Settings-->
    <template>
        <v-row justify="center">
            <v-dialog v-model="modal_settings" persistent hide-overlay transition="dialog-bottom-transition" style="z-index: 1031;" max-width="850" >
                <v-card>
                    <v-toolbar dark color="primary">
                        <v-btn icon dark @click="modal_settings = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title>Настройки</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark text @click="saveDateSemester">Сохранить</v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-list three-line subheader>
                        <v-list-item>
                            <v-list-item-content>
                                <v-row>
                                    <template>
                                        <v-expansion-panels>
                                            <v-expansion-panel>
                                                <v-expansion-panel-header>
                                    <!--Первая смена-->
                                                    <template
                                                            v-slot:default="{ open }"
                                                    >
                                                        <v-row no-gutters>
                                                            <v-col
                                                                    cols="4">{{shift_1.label}}</v-col>
                                                            <v-col
                                                                    cols="8"
                                                                    class="text--secondary"
                                                            >
                                                                <v-fade-transition leave-absolute>
                                                                <span
                                                                        v-if="open"
                                                                        key="0"
                                                                >
                                                                </span>
                                                                    <span
                                                                            v-else
                                                                            key="1"
                                                                    >
                                                                </span>
                                                                </v-fade-transition>
                                                            </v-col>
                                                        </v-row>
                                                    </template>
                                                </v-expansion-panel-header>
                                                <v-expansion-panel-content>
                                                    <div class="col-md-6">
                                                        <v-text-field
                                                                v-model="shift_1.label"
                                                                placeholder="Название"
                                                                outlined
                                                        ></v-text-field>
                                                    </div>
                                                    <template>

                                                        <v-data-table
                                                                :headers="headers"
                                                                :items="time_lesson[0]"
                                                                hide-default-footer
                                                                class="elevation-1"
                                                        >
                                                            Edit start_time
                                                            <template v-slot:item.begin_time="props">
                                                                <v-edit-dialog
                                                                        :return-value.sync="props.item.begin_time"
                                                                        large
                                                                        persistent
                                                                >
                                                                    <div>
                                                                        {{ props.item.begin_time }}
                                                                    </div>
                                                                    <template v-slot:input>
                                                                        <div class="mt-4 title">Конец</div>
                                                                    </template>
                                                                    <template v-slot:input>
                                                                        <v-text-field
                                                                                v-model="props.item.begin_time"
                                                                                label="Edit"
                                                                                single-line
                                                                                autofocus
                                                                                type="time"
                                                                                suffix="PST"
                                                                        ></v-text-field>
                                                                    </template>
                                                                </v-edit-dialog>
                                                            </template>
                                                <!--Edit end_time-->
                                                            <template v-slot:item.end_time="props">
                                                                <v-edit-dialog
                                                                        :return-value.sync="props.item.end_time"
                                                                        large
                                                                        persistent
                                                                >

                                                                    <div>{{ props.item.end_time }}</div>
                                                                    <template v-slot:input>
                                                                        <div class="mt-4 title">Конец</div>
                                                                    </template>
                                                                    <template v-slot:input>
                                                                        <v-text-field
                                                                                v-model="props.item.end_time"
                                                                                label="Edit"
                                                                                single-line
                                                                                autofocus
                                                                                type="time"
                                                                                suffix="PST"
                                                                        ></v-text-field>
                                                                    </template>
                                                                </v-edit-dialog>
                                                            </template>
                                                <!--Edit lesson_break-->
                                                            <template v-slot:item.lesson_break="props">
                                                                <v-edit-dialog
                                                                        :return-value.sync="props.item.lesson_break"
                                                                        large
                                                                        persistent
                                                                >

                                                                    <div>{{ props.item.lesson_break}}</div>
                                                                    <template v-slot:input>
                                                                        <div class="mt-4 title">Перемена</div>
                                                                    </template>
                                                                    <template v-slot:input>
                                                                        <v-text-field
                                                                                v-model="props.item.lesson_break"
                                                                                label="Edit"
                                                                                single-line
                                                                                autofocus
                                                                                type="time"
                                                                                suffix="PST"
                                                                        ></v-text-field>
                                                                    </template>
                                                                </v-edit-dialog>
                                                            </template>

                                                            <v-snackbar v-model="snack" :timeout="3000"
                                                                        :color="snackColor">
                                                                {{ snackText }}

                                                                <template v-slot:action="{ attrs }">
                                                                    <v-btn v-bind="attrs" text @click="snack = false">
                                                                        Close
                                                                    </v-btn>
                                                                </template>
                                                            </v-snackbar>

                                                        </v-data-table>
                                                        <template >
                                                                <v-btn
                                                                        :shift="`${shifts[0]?.value}`"
                                                                        @click=""
                                                                        color="#409EFF"
                                                                        class="mt-2 pull-left white--text"
                                                                        rounded
                                                                        elevation="6"
                                                                        height="40"
                                                                        widht="140"
                                                                        ref="add_1"
                                                                >
                                                                    Добавить пару
                                                                </v-btn>
                                                        </template>
                                                        <v-btn
                                                            color="#409EFF"
                                                            class="mt-2 pull-right white--text"
                                                            rounded
                                                            elevation="6"
                                                            height="40"
                                                            widht="140"
                                                            @click="setTimeLesson(0), setTitleShift()"
                                                        >
                                                            Сохранить
                                                        </v-btn>
                                                    </template>
                                                </v-expansion-panel-content>
                                            </v-expansion-panel>
                                    <!--Вторая смена-->
                                            <v-expansion-panel>
                                                <v-expansion-panel-header>
                                                    <template
                                                            v-slot:default="{ open }"
                                                    >
                                                        <v-row no-gutters>
                                                            <v-col cols="4">{{shift_2.label}}</v-col>
                                                            <v-col
                                                                    cols="8"
                                                                    class="text--secondary"
                                                            >
                                                                <v-fade-transition leave-absolute>
                                                                <span
                                                                        v-if="open"
                                                                        key="0"
                                                                >
                                                                </span>
                                                                    <span
                                                                            v-else
                                                                            key="1"
                                                                    >
                                                                </span>
                                                                </v-fade-transition>
                                                            </v-col>
                                                        </v-row>
                                                    </template>
                                                </v-expansion-panel-header>
                                                <v-expansion-panel-content>
                                                    <v-text-field
                                                            v-model="shift_2.label"
                                                            placeholder="Название"
                                                            outlined
                                                    ></v-text-field>

                                                    <template>

                                                        <v-data-table
                                                                :headers="headers"
                                                                :items="time_lesson[1]"
                                                                hide-default-footer
                                                                class="elevation-1"
                                                        >
                                                            Edit start_time
                                                            <template v-slot:item.begin_time="props">
                                                                <v-edit-dialog
                                                                        :return-value.sync="props.item.begin_time"
                                                                        large
                                                                        persistent
                                                                >
                                                                    <div>
                                                                        {{ props.item.begin_time }}
                                                                    </div>
                                                                    <template v-slot:input>
                                                                        <div class="mt-4 title">Конец</div>
                                                                    </template>
                                                                    <template v-slot:input>
                                                                        <v-text-field
                                                                                v-model="props.item.begin_time"
                                                                                label="Edit"
                                                                                single-line
                                                                                autofocus
                                                                                type="time"
                                                                                suffix="PST"
                                                                        ></v-text-field>
                                                                    </template>
                                                                </v-edit-dialog>
                                                            </template>
                                                            <!--Edit end_time-->
                                                            <template v-slot:item.end_time="props">
                                                                <v-edit-dialog
                                                                        :return-value.sync="props.item.end_time"
                                                                        large
                                                                        persistent
                                                                >

                                                                    <div>{{ props.item.end_time }}</div>
                                                                    <template v-slot:input>
                                                                        <div class="mt-4 title">Конец</div>
                                                                    </template>
                                                                    <template v-slot:input>
                                                                        <v-text-field
                                                                                v-model="props.item.end_time"
                                                                                label="Edit"
                                                                                single-line
                                                                                autofocus
                                                                                type="time"
                                                                                suffix="PST"
                                                                        ></v-text-field>
                                                                    </template>
                                                                </v-edit-dialog>
                                                            </template>
                                                            <!--Edit lesson_break-->
                                                            <template v-slot:item.lesson_break="props">
                                                                <v-edit-dialog
                                                                        :return-value.sync="props.item.lesson_break"
                                                                        large
                                                                        persistent
                                                                >

                                                                    <div>{{ props.item.lesson_break}}</div>
                                                                    <template v-slot:input>
                                                                        <div class="mt-4 title">Перемена</div>
                                                                    </template>
                                                                    <template v-slot:input>
                                                                        <v-text-field
                                                                                v-model="props.item.lesson_break"
                                                                                label="Edit"
                                                                                single-line
                                                                                autofocus
                                                                        ></v-text-field>
                                                                    </template>
                                                                </v-edit-dialog>
                                                            </template>

                                                            <v-snackbar v-model="snack" :timeout="3000"
                                                                        :color="snackColor">
                                                                {{ snackText }}

                                                                <template v-slot:action="{ attrs }">
                                                                    <v-btn v-bind="attrs" text @click="snack = false">
                                                                        Close
                                                                    </v-btn>
                                                                </template>
                                                            </v-snackbar>

                                                        </v-data-table>
                                                        <template >
                                                            <v-btn
                                                                    :shift="`${shifts[1]?.value}`"
                                                                    @click="addCouple_2"
                                                                    color="#409EFF"
                                                                    class="mt-2 pull-left white--text"
                                                                    rounded
                                                                    elevation="6"
                                                                    height="40"
                                                                    widht="140"
                                                                    ref="add_2"
                                                            >
                                                                Добавить пару
                                                            </v-btn>
                                                        </template>
                                                        <v-btn
                                                                color="#409EFF"
                                                                class="mt-2 pull-right white--text"
                                                                rounded
                                                                elevation="6"
                                                                height="40"
                                                                widht="140"
                                                                @click="setTimeLesson(1), setTitleShift"
                                                        >
                                                            Сохранить
                                                        </v-btn>
                                                    </template>
                                                </v-expansion-panel-content>
                                            </v-expansion-panel>

                                        </v-expansion-panels>
                                    </template>
                                </v-row>

                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list three-line subheader>
                        <v-row>
                            <v-col
                            >
                                <v-list-item>
                                    <v-list-item-action>
                                        <v-checkbox
                                                v-model="switch_button"
                                        ></v-checkbox>
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>Вкл/Выкл</v-list-item-title>
                                        <v-list-item-subtitle>Поддержка числитель / знаменатель в расписании</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>

                            <!-- item 1 полугодие-->
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-container grid-list-md>
                                        <v-layout row wrap>
                                            <v-col xs-6>
                                                <v-menu
                                                        href="menu1"
                                                        v-model="menu1"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        max-width="290px"
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on }" >
                                                        <v-text-field
                                                                v-model="computedDateFormattedMomentjs(date_start_first_half)"
                                                                label="Дата начала 1-го полугодия"
                                                                persistent-hint
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker
                                                            v-model="date_start_first_half"
                                                            no-title
                                                            locale="ru"
                                                            first-day-of-week="1"
                                                            @input="menu1 = false"
                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>

                                            <v-col xs-6>
                                                <v-menu
                                                        v-model="menu2"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        max-width="290px"
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on }">
                                                        <v-text-field
                                                                v-model="computedDateFormattedMomentjs(date_finish_first_half)"
                                                                label="Дата окончания 1-го полугодия"
                                                                persistent-hint
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker
                                                            v-model="date_finish_first_half"
                                                            no-title
                                                            locale="ru"
                                                            first-day-of-week="1"
                                                            @input="menu2 = false"></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                        </v-layout>
                                        </v-container>
                                    </v-list-item-content>
                                </v-list-item>
                            <!-- item 2 полугодие-->
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-container grid-list-md>
                                            <v-layout row wrap>
                                                <v-flex>
                                                    <v-menu
                                                            href="menu3"
                                                            v-model="menu3"
                                                            :close-on-content-click="false"
                                                            :nudge-right="40"
                                                            transition="scale-transition"
                                                            offset-y
                                                            max-width="290px"
                                                            min-width="290px"
                                                    >
                                                        <template v-slot:activator="{ on }">
                                                            <v-text-field
                                                                    :value="computedDateFormattedMomentjs(date_start_second_half)"
                                                                    label="Дата начала 2-го полугодия"
                                                                    persistent-hint
                                                                    v-on="on"
                                                            ></v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                                v-model="date_start_second_half"
                                                                no-title
                                                                locale="ru"
                                                                first-day-of-week="1"
                                                                @input="menu3 = false"></v-date-picker>
                                                    </v-menu>
                                                </v-flex>

                                                <v-flex>
                                                    <v-menu
                                                            href="menu4"
                                                            v-model="menu4"
                                                            :close-on-content-click="false"
                                                            :nudge-right="40"
                                                            transition="scale-transition"
                                                            offset-y
                                                            max-width="290px"
                                                            min-width="290px"
                                                    >
                                                        <template v-slot:activator="{ on }">
                                                            <v-text-field
                                                                    :value="computedDateFormattedMomentjs(date_finish_second_half)"
                                                                    label="Дата окончание 2-го полугодия"
                                                                    persistent-hint
                                                                    v-on="on"
                                                            ></v-text-field>
                                                        </template>
                                                        <v-date-picker
                                                                v-model="date_finish_second_half"
                                                                no-title
                                                                locale="ru"
                                                                first-day-of-week="1"
                                                                @input="menu4 = false"
                                                        ></v-date-picker>
                                                    </v-menu>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-col>



                        </v-row>

                    </v-list>
                </v-card>
            </v-dialog>
        </v-row>
    </template>

    <!-- end modal settings -->

    <pre v-cloak></pre>

</v-app>


<script>
    Vue.config.warnHandler = function(msg, vm, trace) {
        console.log(`Warn: ${msg}\nTrace: ${trace}`);
    }
    var startApp = {};
    var init = function () {
        wlAppSchedule = new Vue({
            el: '#app',
            renderError (h, err) {
                return h('pre', { style: { color: 'red' }}, err.stack)
            },
            vuetify: new Vuetify(),
            data() {
                return {
                    menu1: false,
                    menu2: false,
                    menu3: false,
                    menu4: false,

                    snack: false,
                    snackColor: '',
                    snackText: '',

                    headers: [
                        {
                            text: '№',
                            align: 'start',
                            sortable: false,
                            value: 'id',
                        },
                        { text: 'Начало', value: 'begin_time', sortable: false},
                        { text: 'Конец', value: 'end_time', sortable: false},
                        { text: 'Перемена', value: 'lesson_break', sortable: false},

                    ],

                    time_lesson: [],

                    show_button: false,

                    currentDate: new Date(),

                    date_start_first_half: '',
                    date_finish_first_half: '',
                    date_start_second_half: '',
                    date_finish_second_half: '',

                    correct_date: null,

                    number_week_day_first: null,
                    number_week_day_second: null,

                    options: [
                        {
                            value: 'Option1',
                            label: 'Option1'
                        },
                        {
                            value: 'Option2',
                            label: 'Option2'
                        },
                        {
                            value: 'Option3',
                            label: 'Option3'
                        },
                        {
                            value: 'Option4',
                            label: 'Option4'
                        },
                        {
                            value: 'Option5',
                            label: 'Option5'
                        }
                    ],
                    value: '',

                    // filter_department: '',
                    departments: [],
                    filter_department: '',

                    //группы
                    studentgroups: [],
                    filter_studentgroup: '',

                    // преподователь
                    teachers: [],
                    filter_teacher: '',

                    //дисциплины
                    disciplines: [],
                    filter_discipline: '',

                    //формы обучения
                    eduforms: [],
                    filter_eduform: '',

                    //язык обучения
                    edulangs: [
                        {value: '1', label: 'Русский'},
                        {value: '2', label: 'Казахский'},

                    ],
                    filter_edulang: '',


                    //курс
                    courselist: [
                        {value: '1', label: '1'},
                        {value: '2', label: '2'},
                        {value: '3', label: '3'},
                        {value: '4', label: '4'}
                    ],

                    filter_course: '',

                    // смена
                    shifts: [],
                    filter_shift: '',

                    shift_1: { value: '1', label: '' },
                    shift_2: { value: '2', label: '' },



                    // день недели
                    weekdays: [
                        { value: '1', label: 'Понедельник' },
                        { value: '2', label: 'Вторник' },
                        { value: '3', label: 'Среда' },
                        { value: '4', label: 'Четверг' },
                        { value: '5', label: 'Пятница'},
                        { value: '6', label: 'Суббота'},
                    ],

                    array_dates_weekdays: [],

                    // семестр
                    semesters: [
                        {value: '1', label: '1-й'},
                        {value: '2', label: '2-й'},
                    ],
                    filter_semester: '',

                    // неделя
                    weeks: [
                    ],
                    filter_week: '',

                    copy_settings: [
                        { value: '1', label: 'на след. неделю' },
                        { value: '2', label: 'на след. семестр' },
                    ],
                    filter_copy: '',

                    tableData: [],

                    groups: [],

                    valid: false,

                    nameRules: [
                        v => !!v || 'Name is required',
                    ],

                    select: null,

                    custom: {
                        select: {
                            required: 'Select field is required'
                        }
                    },

                    selectedGroup: {},
                    groupSelect: [],

                    info: {
                        couple: 0,
                        weekday: 0,
                        subgroup: 0,
                    },

                    change_info: {},

                    change_card: false,


                    smoke: {
                        smoke: false
                    },

                    bg_changed: 'bg-changed',

                    classrooms: [],
                    filter_classroom: '',

                    add_lesson_modal: false,

                    modal_show: false,

                    types_lesson: [],
                    filter_type: '',

                    add_lesson: {
                        classroom: '',
                    },

                    add_lesson_completed: true,

                    modal_loading: false,
                    modal_finish_copy: false,
                    modal_text: '',

                    filter_couple: 1,

                    delete_lesson: true,


                    decimal_numbers: [],
                    filter_decimal_number: '',

                    subgroups: [],
                    filter_subgroup: '',

                    tab: null,

                    tabs: [
                        { title: 'Изменить преподователя/дисциплины' },
                        { title: 'Заменить аудитории' }
                    ],

                    show_copy: false,

                    modal_settings: false,

                    switch_button: false,

                    workload_distributed: '',

                    workload_total: {},

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
                filter_department: function () {
                    this.getGroups();
                    this.getDisciplines();
                },

                filter_eduform: function () {
                    this.getGroups();
                },

                filter_edulang: function () {
                    this.getGroups();
                },
                filter_course: function () {
                    this.getGroups();
                },

                filter_studentgroup: function () {
                },

                filter_semester: function() {
                    this.countWeek();
                    this.calculationDateSelectedWeek();
                    this.fillArrayDateSelectedWeek();
                    this.resetSchedule();
                },

                filter_week: function() {
                    this.fillArrayDateSelectedWeek();
                    this.resetSchedule();
                },

                date_start_first_half: function () {
                    this.calculationDateSelectedWeek();
                },

                date_start_second_half: function () {
                    this.calculationDateSelectedWeek();
                },

                add_lesson_modal: function () {
                    this.getTypeLesson();
                    this.getClassrooms();
                    this.getGroups();
                },

                change_card: function () {
                    this.getTypeLesson();
                },


                delete_lesson: function () {
                    //this.getSchedule();
                },

                add_lesson_completed: function () {
                    //this.getSchedule();
                },

                modal_settings: function () {
                },

            },

            methods: {

                initAppProc() {
                    this.getDepartments();
                    this.getGroups();
                    this.getDisciplines();
                    this.getEducationForm();
                    this.getTitleShift();
                    this.getTeachers();
                    this.getClassrooms();
                    this.getSettingsSchedule();
                    this.getTimeLessons();
                },

                computedDateFormattedMomentjs: (data) => {
                    return data ? moment(data).locale('ru').format('LL') : '';
                },

                //
                // computedLabel_2: function() {
                //     return this.shifts[1]?.label;
                // },

                btn_search_click() {
                    this.getSchedule();
                },

                subgroup_func(couple) {
                    const element = this.$refs.couple[couple - 1];
                    $(element).add
                },

                getFullName(item) {
                    return item.teacher.firstname + ' ' + item.teacher.lastname;
                },


                /**
                 * Кафедры
                 */

                getDepartments() {
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-departments',
                        data: {},
                        success: function (result) {
                            if (result) {
                                wlAppSchedule.departments = $.map(JSON.parse(result), function (e) {
                                    return {
                                        value: e.id,
                                        label: JSON.parse(e.caption).ru
                                    }
                                });
                            } else {
                                return [];
                            }
                        },
                        fail: function (data) {

                            wlAppSchedule.message('Error, request not append');
                        }
                    });

                },

                /**
                 * Группы
                 */
                getGroups() {
                    let dept_id = this.filter_department ? this.filter_department : '';
                    let edu_form = this.filter_eduform? this.filter_eduform : '';
                    let edu_lang = this.filter_edulang? this.filter_edulang : '';
                    let course = this.filter_course? this.filter_course : '';
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-groups?department_id=' + dept_id + '&edu_form=' + edu_form + '&edu_lang=' + edu_lang + '&curs=' + course,
                        data: {},
                        success: function (data) {
                            if (data) {
                                wlAppSchedule.studentgroups = $.map(JSON.parse(data), function (e) {
                                    return {
                                        value: e.id,
                                        label: JSON.parse(e.caption).ru
                                    }
                                });
                            } else {
                                return [];
                            }

                        },
                    });
                },

                /**
                 * Преподаватели
                 */
                getTeachers() {
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-teachers?',
                        data: {},
                        success: function (data) {
                            if (data) {
                                wlAppSchedule.teachers = $.map(JSON.parse(data), function (e) {
                                    return {
                                        value: e.id,
                                        label: e.firstname + ' ' + e.lastname
                                    }
                                });
                            } else {
                                return [];
                            }

                        },
                    });
                },

                /**
                 *  Дисциплины
                 */
                getDisciplines() {
                    let dept_id = this.filter_department ? this.filter_department : ''
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-disciplines?id=' + dept_id,
                        data: {},
                        success: function (data) {
                            if (data) {
                                wlAppSchedule.disciplines = $.map(JSON.parse(data), function (e) {
                                    return {
                                        value: e.id,
                                        label: JSON.parse(e.caption).ru
                                    }
                                });
                            } else {
                                return [];
                            }

                        },
                    });
                },

                /**
                 * форма обучения
                 * [
                 *   очная
                 *   заочная
                 *   вечернее
                 * ]
                 */
                getEducationForm() {
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-education-form',
                        data: {},
                        success: function (data) {
                            if (data) {
                                wlAppSchedule.eduforms = $.map(JSON.parse(data), function (value, key) {
                                    return {
                                        value: key,
                                        label: value,
                                    }
                                });
                            } else {
                                return [];
                            }
                        },
                    });
                },


                /**
                 * Язык обучения
                 *  [
                 *      русский
                 *      казахский
                 *  ]
                 */
                getEduLangs() {
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-edu-langs',
                        data: {},
                        success: function (data) {
                            if (data) {
                                wlAppSchedule.edulangs = $.map(JSON.parse(data), function (value, key) {
                                    return {
                                        value: key,
                                        label: value,
                                    }
                                });
                            } else {
                                return [];
                            }
                        },
                    });

                },

                /**
                 *  Семестр
                 */

                getSemester() {
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-semester',
                        data: {},
                        success: function (data) {
                            if (data) {
                                wlAppSchedule.semesters = $.map(JSON.parse(data), function (value, key) {
                                    return {
                                        value: key,
                                        label: value
                                    }
                                });
                            } else {
                                return [];
                            }
                        },
                    });
                },

                setShiftTitle() {
                  axios.post('/timetable/new-schedule/set-shift-title', {
                      id: wlAppSchedule.shifts.value,
                      title: wlAppSchedule.shifts.label
                  })
                    .then((response) => (console.log(response)))
                    .catch(error => console.log(error))
                },

                getTitleShift() {
                    axios.get('/timetable/new-schedule/get-shift-title')
                        .then(function(response) {
                            if(response.status == 200) {
                                wlAppSchedule.shifts = $.map(response.data,  (e, key) => {
                                    return {
                                        value: e.id ? e.id : key,
                                        label: e.title ? e.title : `Название смены ${key}`
                                    }
                                })
                            }
                        })
                        .catch(error => console.log(error));
                },


                /**
                 * Расписание
                 */

                getSchedule() {
                    if (this.$refs.form.validate()) {
                        let teacher = this.filter_teacher ? this.filter_teacher : '';
                        let semester = this.filter_semester ? this.filter_semester : '';
                        let shift = this.filter_shift ? this.filter_shift : '';
                        let week = this.filter_week ? this.filter_week : '';
                        let group = this.filter_studentgroup ? this.filter_studentgroup : '';
                        let disc = this.filter_discipline ? this.filter_discipline : '';
                        let dept = this.filter_department ? this.filter_department : '';
                        let edu_lang = this.filter_edulang ? this.filter_edulang : '';
                        let edu_form = this.filter_eduform ? this.filter_eduform : '';
                        $.ajax({
                            type: 'GET',
                            url: '/timetable/new-schedule/get-schedule-card?teacher_id=' + teacher + '&semester=' + semester + '&shift=' + shift + '&week=' +
                                week + '&group=' + group + '&discipline=' + disc + '&department=' + dept + '&edu_lang=' +
                                edu_lang + '&edu_form=' + edu_form,
                            data: {},
                            success: (data) => {
                                if (data) {
                                    this.tableData = data;
                                    this.show_copy = true;
                                } else {
                                    return [];
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            },

                        });
                    }
                },

                /**
                 * Аудитории
                 */
                getClassrooms() {
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-classrooms',
                        data: {},
                        success: function (data) {
                            if (data) {
                                wlAppSchedule.classrooms = JSON.parse(data);
                            } else {
                                return [];
                            }
                        },
                        fail: function (data) {
                            wlAppSchedule.message('Error, request not append');
                        }
                    });
                },

                getTypeLesson() {
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/get-types',
                        data: {},
                        success: function (data) {
                            if (data) {
                                wlAppSchedule.types_lesson = JSON.parse(data);
                            } else {
                                return [];
                            }
                        },
                        fail: function (data) {
                            wlAppSchedule.message('Error, request not append');
                        }
                    });

                },


                modifyCard(info) {
                    $.ajax({
                        type: 'POST',
                        url: '/timetable/new-schedule/modify-card',
                        data: {
                            id: info.id,
                            teacher_id: info.teacher_id,
                            classroom_id: info.classroom_id,
                            type_id: info.type_id,
                            discipline_id: info.discipline_id,
                        },
                        success: function (data) {
                            wlAppSchedule.change_card = data;
                            wlAppSchedule.getSchedule();
                        },
                        fail: function (data) {
                            wlAppSchedule.message('Error, request not append');
                        }
                    });
                },

                addLesson() {
                    $.ajax({
                        type: 'POST',
                        url: '/timetable/new-schedule/add-lesson',
                        data: {
                            department_id: this.filter_department,
                            discipline_id: this.filter_discipline,
                            type_id: this.filter_type,
                            classroom_id: this.add_lesson.classroom,
                            teacher_id: this.filter_teacher,
                            ref_group_id: this.filter_studentgroup,
                            semester: this.filter_semester,
                            shift_time: this.filter_shift,
                            week: this.filter_week,
                            weekday: this.info.weekday,
                            couple: this.info.couple,
                            subgroup: this.info.subgroup
                        },
                        success: (data) => {
                            if(data) {
                                let ret = JSON.parse(data);

                                this.discipline_id = '';
                                this.filter_type = '';
                                this.filter_subgroup = '';
                                this.teacher_id = '';
                                this.add_lesson.classroom = '';
                                this.filter_decimal_number = '';
                                this.add_lesson_completed = false;

                                //console.log(ret.classroom_id.toString());
                                nles =
                                {
                                    classroom: this.classrooms.find(x=> x.id === +ret.classroom_id),
                                    classroom_id: ret.classroom_id,
                                    couple: ret.couple,
                                    course: ret.course,
                                    department_id: ret.department_id,
                                    discipline: { caption :  JSON.stringify({ ru : this.disciplines.find(x=> x.value === +ret.discipline_id)?.label }) },
                                    discipline_id: ret.discipline_id,
                                    edu_form: ret.edu_form,
                                    edu_lang: ret.edu_lang,
                                    group: { caption : JSON.stringify( { ru : this.studentgroups.find(x=> x.value === +ret.ref_group_id)?.label }) },
                                    id: ret.id,
                                    reason_id: null,
                                    ref_group_id: ret.ref_group_id,
                                    semester: ret.semester,
                                    shift_time: ret.shift_time,
                                    teacher: {id: this.teachers.find(x=> x.value === +ret.teacher_id)?.value, firstname: this.teachers.find(x=> x.value === +ret.teacher_id)?.label, lastname: ''} ,
                                    teacher_id: ret.teacher_id,
                                    type_id: ret.type_id,
                                    types: this.types_lesson.find(x=> x.id === +ret.type_id),
                                    updated_at: null,
                                    week: ret.week,
                                    weekday: ret.weekday,
                                    subgroup: ret.subgroup
                                };
                                // console.log(nles);
                                wlAppSchedule.tableData[this.info.couple][this.info.weekday][this.info.subgroup] = nles; //добавляем в календарь
                                this.getDistributedWorkload();   //  запрос сколько уже распределено часов
                            } else {
                                console.log('no lesson data');
                            }
                        },
                        fail: function (data) {
                            wlAppSchedule.message('Error, request not append');
                        }
                    });
                },

                deleteLesson(id) {
                    $.ajax({
                        type: 'GET',
                        url: '/timetable/new-schedule/delete-lesson?id=' + id,
                        data: {},
                        success: function (data) {
                            //console.log(data);
                            wlAppSchedule.delete_lesson = data;

                            del_les = wlAppSchedule.tableData[wlAppSchedule.info.couple][wlAppSchedule.info.weekday][wlAppSchedule.info.subgroup];
                            del_les.discipline_id = 0;
                            del_les.classroom= null;
                            del_les.classroom_id= 0;
                            del_les.couple= 0;
                            del_les.course= 0;
                            del_les.department_id= 0;
                            del_les.discipline= null;
                            del_les.edu_form= 0;
                            del_les.edu_lang= 0;
                            del_les.group= null;
                            //del_les.id: ret.id,
                            del_les.reason_id= null;
                            del_les.ref_group_id= 0;
                            //del_les.semester: ret.semester,
                            //del_les.shift_time: ret.shift_time,
                            del_les.teacher= null;
                            del_les.teacher_id= 0;
                            del_les.type_id= 0;
                            del_les.types= null;
                            del_les.updated_at= null;
                            //del_les.week: ret.week,
                            //del_les.weekday: ret.weekday
                        },
                        fail: function (data) {
                            wlAppSchedule.message('Error, request not append');
                        }
                    });

                },

                getDistributedWorkload() {
                    axios.post('/timetable/new-schedule/get-distributed-workload-on-teacher', {
                        group_id: this.filter_studentgroup,
                        teacher_id: this.filter_teacher,
                        discipline_id: this.filter_discipline,
                        semester: this.filter_semester
                    })
                        .then( function(response) {
                            wlAppSchedule.workload_distributed = (response.data * 90 / 60);
                            wlAppSchedule.getWorkloadOnTeacher(); // запрос нагрузки по РУПам
                        })
                        .catch(error => console.log(error))
                },

                getWorkloadOnTeacher() {
                    axios.post('/workload/workloadgroup/get-workload-group-teacher', {
                        teacher_id: this.filter_teacher,
                        group_id: this.filter_studentgroup,
                        discipline_id: this.filter_discipline,
                        year: this.currentDate.getFullYear(),
                    })
                        .then(function(response) {
                            console.log(response.data);
                            wlAppSchedule.workload_total = response.data;
                            wlAppSchedule.calculationWorkloadTeacher();
                        })
                        .catch(error => console.log(error))
                },

                calculationWorkloadTeacher() {
                    let periodTime = 'pol' + this.filter_semester + '_time';  // динамически собирается св-ва объекта из строки
                    if(this.workload_total[periodTime] < this.workload_distributed) {
                        const h = wlAppSchedule.$createElement;
                        wlAppSchedule.$notify.info({
                            title: 'Ошибка',
                            message: h('i', { style: 'color: Danger' }, 'Предупреждаю больше этот преподователь не выдержит'),
                            duration:5000
                        });
                        return false;
                    } else if(this.workload_total[periodTime] == this.workload_distributed) {
                        const h = wlAppSchedule.$createElement;
                        wlAppSchedule.$notify.info({
                            title: 'Ошибка',
                            message: h('i', { style: 'color: Danger' }, 'Предупреждаю вся нагрузка на преподавателя распределена'),
                            duration:5000
                        });
                        return false;
                    }

                },


                copySchedule() {
                    $.ajax({
                        type: 'POST',
                        url: '/timetable/new-schedule/copy-schedule',
                        data: {
                            id: this.filter_copy,
                            week: this.filter_week,
                            semester: this.filter_semester,
                            group: this.filter_studentgroup
                        },
                        success: function (data) {
                            wlAppSchedule.modal_loading = false;
                            wlAppSchedule.modal_text = 'Расписание скопировано';
                            wlAppSchedule.modal_finish_copy = true;

                        },
                        fail: function (data) {
                            wlAppSchedule.modal_loading = false;
                            wlAppSchedule.modal_text = 'Ошибка копирования';
                            wlAppSchedule.modal_finish_copy = true;
                        }
                    });

                },

                /**
                 * @param unix
                 * @returns {string}
                 */
                formatDate(unix) {
                    const date = new Date(unix * 1000); // convert to milliseconds
                    const year = date.getFullYear();
                    let month = date.getMonth() + 1;
                    let day = date.getDate();

                    // Check if day or month is only 1 digit
                    // this because Moment.js works with 0 leading values
                    if (day.toString().length !== 2) day = `0${day}`;
                    if (month.toString().length !== 2) month = `0${month}`;

                    return `${day}-${month}-${year}`;
                },

                saveDateSemester() {
                    axios.post('/timetable/new-schedule/save-date-semester', {
                        start_first_half_year: this.date_start_first_half,
                        finish_first_half_year:  this.date_finish_first_half,
                        start_second_half_year: this.date_start_second_half,
                        finish_second_half_year: this.date_finish_second_half,
                        numerator_denominator_status: this.switch_button ? 1 : 0,
                    })
                    .then( function(response) {
                        if (response.status == 200 && response.statusText == 'OK') {
                            wlAppSchedule.modal_settings = false;
                        }
                    })
                    .catch(error => console.log(error))
                },

                getSettingsSchedule() {
                  axios.get('/timetable/new-schedule/get-settings-schedule')
                        .then((response) => {
                            this.shift_1 = this.shifts[0];
                            this.shift_2 = this.shifts[1];
                            this.switch_button = response.data.numerator_denominator_status;
                            this.date_start_first_half = response.data.start_first_half_year;
                            this.date_finish_first_half = response.data.finish_first_half_year;
                            this.date_start_second_half = response.data.start_second_half_year;
                            this.date_finish_second_half = response.data.finish_second_half_year;
                            this.tableData = [];
                        })
                        .catch(error => console.log(error))
                },

                save () {
                    this.snack = true
                    this.snackColor = 'success'
                    this.snackText = 'Data saved'
                },
                cancel () {
                    this.snack = true
                    this.snackColor = 'error'
                    this.snackText = 'Canceled'
                },
                open () {
                    this.snack = true
                    this.snackColor = 'info'
                    this.snackText = 'Dialog opened'
                },
                close () {
                    console.log('Dialog closed')
                },

                setTimeLesson(shift) {
                    axios.post('/timelesson/time-lesson-schedule/set-time-lessons', {
                        data: this.time_lesson[shift],
                    })
                        .then((response) => ( wlAppSchedule.modal_settings = false ))
                        .catch(error => console.log(error))
                },

                getTimeLessons() {
                    axios.post('/timelesson/time-lesson-schedule/get-time-lessons')
                        .then(function(response) {
                            let arr = response.data.filter((item) => {
                                if (+item.shift_id === 1) {
                                    return item;
                                }
                            });
                            let arr2 = response.data.filter((item) => {
                               if(+item.shift_id === 2) {
                                   return item;
                               }
                            });

                            wlAppSchedule.time_lesson.push(arr);
                            wlAppSchedule.time_lesson.push(arr2);
                        })
                        .catch(error => console.log(error))
                },




                setTitleShift() {
                    Vue.set(this.shifts, 0, this.shift_1);
                    Vue.set(this.shifts, 1, this.shift_2);
                    axios.post('/timetable/new-schedule/set-shift-title', {
                        data: this.shifts
                    })
                    .then((response) => {
                            wlAppSchedule.shifts = $.map(response.data, (e) => {
                                return {
                                    value: e.id,
                                    label: e.title
                                }
                            })
                        console.log();
                    })
                    .catch(error => console.log(error))
                },

                addCouple_2() {
                    console.log(this.$refs.add_2.$attrs.shift);
                    let el = {'id': '', 'begin_time': '_', 'end_time': '_', 'lesson_break': '_', 'shift': ''};
                    el.shift = this.$refs.add_2.$attrs.shift;
                    let index = this.$refs.add_2.$attrs.shift - 1;

                    this.time_lesson[index].push(el);
                },

                setShiftLesson(item, value) {
                    console.log(item, value);
                },

                computedTime(couple) {
                    if (wlAppSchedule.filter_shift) {
                        let index1 = wlAppSchedule.filter_shift;
                        let el = `${wlAppSchedule.time_lesson[index1 - 1][couple - 1]?.begin_time ? wlAppSchedule.time_lesson[index1 - 1][couple - 1]?.begin_time : ''}-${wlAppSchedule.time_lesson[index1 - 1][couple - 1]?.end_time ? wlAppSchedule.time_lesson[index1 - 1][couple - 1]?.end_time : ''}`;
                        return el;
                    } else {
                        return;
                    }
                },

                computeDate() {
                    if(this.filter_semester == 1) {
                        let date = new Date(this.date_start_first_half);
                        let week = this.filter_week;
                        let dateWeek = date.setDate(date.getDate() + (7*week));
                    } else if(this.filter_semester == 2) {
                        const weeknumber_2 = moment(this.start_first_half_year, "DD-MM-YYYY").isoWeek();
                    }
                },
                // Кол-во недель в семестре
                countWeek() {
                    if(this.filter_semester == 1) {
                        this.weeks = [];
                        let period = new Date(this.date_finish_first_half) - new Date(this.date_start_first_half);
                        let countDay = period / (1000 * 60 * 60 * 24);
                        let countWeek = Math.ceil(countDay / 7);
                        for (let i = 1; i <= countWeek; i++) {
                            this.weeks.push({value: i, label: i});
                        }
                    } else if(this.filter_semester == 2){
                        this.weeks = [];
                        let period = new Date(this.date_finish_second_half) - new Date(this.date_start_second_half);
                        let countDay = period / (1000 * 60 * 60 * 24);
                        let countWeek = Math.ceil(countDay / 7);
                        for (let i = 1; i <= countWeek; i++) {
                            this.weeks.push({value: i, label: i});
                        }
                    }
                    return this.weeks;
                },

                calculationDateSelectedWeek() {
                    // в зависимости от семестра присваиваем переменной дату
                    let data = (this.filter_semester == 1) ? new Date(this.date_start_first_half) : (this.filter_semester == 2) ? new Date(this.date_start_second_half) : '';

                    // получаю номер дня недели
                    if(data != '') {
                        let numberWeekDay = data.getDay();
                        // выставить день неделина понедельник
                        if (numberWeekDay < 1) {
                            this.correct_date = new Date(data.setDate(data.getDate() + 1));
                        } else if (numberWeekDay > 1) {
                            this.correct_date = new Date(data.setDate(data.getDate()- data.getDay() + 1)).toDateString();
                        } else {
                            this.correct_date = new Date(data).toDateString();
                        }
                    } else {
                        return;
                    }
                },

                fillArrayDateSelectedWeek() {
                    if(this.filter_week) {
                        // correct_date - скорректированная дата на понедельник в зависимости от семестра
                        let new_date = new Date(this.correct_date);
                        // let count_week = this.filter_week;
                        // номер недели
                        let count_week = wlAppSchedule.filter_week;
                        // сдвиг кол-во дней от номера недели
                        let count_offset_days = (count_week - 1) * 7;

                        new_date = new Date(new_date.setDate(new_date.getDate() + count_offset_days));
                        wlAppSchedule.array_dates_weekdays = [];
                        wlAppSchedule.array_dates_weekdays.push(new_date.toDateString());
                        for (let i = 0; i < 5; i++) {
                            const tmp2 = new Date(new_date.setDate(new_date.getDate() + 1)).toDateString();
                            wlAppSchedule.array_dates_weekdays.push(tmp2);
                        }
                    } else {
                        return;
                    }
                },

                resetSchedule() {
                    this.tableData = [];
                },


            }

        })
    }();

</script>

<style>
    .dialogInput {
        width: 200px;
    }

    .dialogDelete {
        height: 155px;
    }

    .groupName {
        width: 400px;
    }

    .column-name {
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .column {
        padding-right: 10px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .nameDisciplines {
        width: 300px;
    }

    .demo-input-label {
        display: inline-block;
        width: 40px;
    }

    .label-center {
        display: flex;
        align-items: center;
    }

    .yearDiv {
        min-width: 105px;
    }

    .separator-line::before {
        content: '';
        position: absolute;
        top: 35%;
        right: 0;
        border-right: 1px solid #000000;
        height: 30%;
    }

    .position-relative {
        position: relative;
    }

    .custom-font {
        font-family: 'Times New Roman', Times, serif;
        font-weight: 700;
        font-size: 24px;
    }

    .v-text-field__details {
        margin-bottom: 0!important;
    }

    .v-input--dense>.v-input__control>.v-input__slot {
        margin-bottom: 0;
    }
    
    .bg-changed {
        background-color: #FFCDD2!important;
    }

    /*smoke*/

    .smoke {
        animation: animate 2s linear forwards;
    }

    @keyframes animate {
        0% {
            transform: rotate(0deg) translateY(0px);
            opacity: 1;
            filter: blur(1px);
        }
        100% {
            transform: rotate(45deg) translateY(-200px);
            opacity: 0;
            filter: blur(20px);
        }
    }
</style>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


