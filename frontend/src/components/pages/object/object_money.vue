<template>

    <div>
        <nav-bar v-on:block-save="blockPage = !blockPage"/>
        <div class="container">

            <div class="row">
                <div class="col-8">
                    <h4>
                        Сведения о поступлениях и расходах на жилой объект
                    </h4>
                </div>
            </div>

            <hr>
            <div class="row mt-2">
                <div class="col-8"><h4>
                    Сведения о площади, проживающих и количестве мест в жилом объекте
                </h4></div>
            </div>
            <div class="row">
                <div class="col-6"><label >Наименование жилого объекта</label></div>
                <div class="col-6">
                    <b-form-select @change="setObject" :options="objectsTitle"/>
                </div>
            </div>
            <b-button v-if="!blockPage" href="/objects-info" variant="outline-secondary">Добавить объект</b-button>

            <hr>


            <h3>Поступления</h3>

            <div class="row">
                <div class="col-6"><label for="object_area_svod">Общий объём поступлений</label></div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <b-form-input type="number" disabled  id="object_area_svod"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        1. Поступления за проживание в жилом объекте без учёта дополнительных услуг
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip1" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip1">
                                Начисленные за предыдущий
                                календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        2. Поступления за дополнительные услуги проживания в жилом объекте
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip2" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip2">
                                Начисленные за предыдущий
                                календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        3. Поступления от аренды помещений жилого объекта
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip3" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip3">
                                Начисленные за предыдущий
                                календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        4. Поступления целевых средств
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip4" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip4">
                                Начисленные за предыдущий
                                календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>



            <hr>


            <h3>Расходы</h3>

            <div class="row">
                <div class="col-6"><label for="object_area_svod">Общий объем средств, направленных на расходы жилого объекта</label></div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <b-form-input type="number" disabled  id="object_area_svod"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        1. Расходы на коммунальные услуги
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        А. Водоснабжение (холодное, горячие, водоотведение)
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip5" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip5">
                                Начисленные за предыдущий
                                календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Б. Тепловая энергия
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip6" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip6">
                                Начисленные за предыдущий
                                календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        В. Природный газ
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip7" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip7">
                                Начисленные за предыдущий
                                календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>


            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Г. Электрическая энергия
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip8" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip8">
                                Начисленные за предыдущий
                                календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>


            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        2. Расходы, связанные с содержанием имущества
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        А. Уборка территории
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip9" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip9">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Б. Уборка помещений
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip10" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip10">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        В. Техническое обслуживание
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip11" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip11">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>


            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Г. Дератизация, дезинсекция
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip12" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip12">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>


            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Д. Вывоз ТБО
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip13" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip13">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>



            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Е. Государственная поверка, паспортизация
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip14" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip14">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>


            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Ж. Проведение обследования технического состояния (аттестация)
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip15" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip15">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>


            <div class="row">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        З. Противопожарные мероприятия
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip16" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip16">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        И. Иные расходы, связанные с содержанием имущества
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip17" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip17">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>



            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        3. Расходы на обеспечение безопасности проживания
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        А. Услуги охраны
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip18" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip18">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Б. Расходы в рамках антитеррористической защиты
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip19" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip19">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        В. Иные расходы, связанные с обеспечением безопасности
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip20" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip20">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>


            <div class="row">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        4. Расходы на уплату налогов
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" />
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        А. Налог на имущество
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip21" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip21">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-4" for="object_area_neisp">
                        Б. Земельный налог
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip22" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip22">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        5. Расходы на услуги связи
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip23" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip23">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        6. Расходы на капитальный ремонт
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip24" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip24">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        7. Расходы на текущий ремонт
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip25" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip25">
                                Начисленных за предыдущий календарный год,
                                включая заработную плату с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        8. Расходы на приобретение мягкого инвентаря и других материальных запасов
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip26" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip26">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label class="ml-2" for="object_area_neisp">
                        9. Расходы на приобретение основных средств, в том числе мебели
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip27" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip27">
                                Начисленные за предыдущий календарный год
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="object_area_neisp">
                        Фонд оплаты труда
                    </label>
                </div>
                <div class="col-6">
                    <b-input-group append="тысяч рублей">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip28" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip28">
                                Начисленных за предыдущий календарный год,
                                всех категорий сотрудников обслуживающих
                                жилой объект с начислениями
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" :disabled="blockPage"/>
                    </b-input-group>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BFormInput,BInputGroup,BButton,BInputGroupText,BTooltip,
        BFormSelect} from 'bootstrap-vue'
    export default {
        name: "object_money",
        components:{
            NavBar,
            BFormInput,
            BInputGroup,
            BFormSelect,
            BButton,
            BInputGroupText,BTooltip,
        },
        methods:{
            setObject(index){
                this.currentObject = this.objects.find(item=>item.id===index);
                console.log(index,this.currentObject);
            },
        },
        data(){
            return {
                blockPage:true,
                currentObject:{},
                objectsTitle:[
                    {
                        value:1,
                        text:'object 0'
                    }
                ],
                objects:[
                    {
                        id:1,
                        name:'object 0',
                        address:'',
                        id_region:1,
                        kad_number:'',
                        osnov_isp:0,
                        reg_zap:'',
                        doc_number:'',
                        plan_zhil_pom:0,
                        razm_type:0,
                        smet_sum:0,
                        nal_uch_isp_res:0,
                        date_start_stroy:null,
                        date_zdan:null,
                        date_exploat:null,
                        sum_fins:0,
                        schet_fed_bud:0,
                        schet_bud_subj:0,
                        schet_vnebud:0,
                        rek_kap_rem:true,
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>