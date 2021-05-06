<template>
  <div>
    <!--<nav-bar :is-admin="user.isAdmin" :id_org="id_org" v-on:save-page="saveObject"
             v-on:block-save="blockPage = !blockPage"/>-->
    <v-page>
      <div v-if="componentReady" class="container">
        <org-select link="/api/organizations/all" error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" v-if="$check(['admin','root'])" v-model="id_org"/>

        <h3>Шаг 3: Сведения о поступлениях и расходах на объект</h3>

        <div v-if="currentObject">

          <stepper
              :back-url="user.isAdmin ?
          `/admin/objects-area/${id_org}/${$route.params.id_object}` :
          `/objects-area/${$route.params.id_object}`"
              :to-url="user.isAdmin ?
          `/admin/objects-tariff/${id_org}/${$route.params.id_object}` :
          `/objects-tariff/${$route.params.id_object}`"
              percent="60"
              end-button-label="Далее"
              @save-page="savePage"
          />
          <hr>

          <b-alert variant="danger" show>
            <money-icon/>
            <span style="font-size: 1.2rem">Поля должны быть заполнены в рублях.</span>
          </b-alert>

          <h3>Поступления</h3>

          <div class="row">
            <div class="col">
              <label class="font-weight-bold">Общий объём поступлений: </label> {{ money.obsh }} рублей
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                1. Поступления за проживание в жилом объекте без учёта дополнительных услуг
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip1" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip1">
                    Начисленные за предыдущий
                    календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001"
                              type="number" v-model.number="currentObject.money.money_prozh_bez_dop"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                2. Поступления за дополнительные услуги проживания в жилом объекте
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip2" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip2">
                    Начисленные за предыдущий
                    календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.money_prozh_dop"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                3. Поступления от аренды помещений жилого объекта
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip3" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip3">
                    Начисленные за предыдущий
                    календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.money_aren"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                4. Поступления целевых средств
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip4" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip4">
                    Начисленные за предыдущий
                    календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.money_cel_sred"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <hr>

          <h3>Расходы</h3>

          <div class="row">
            <div class="col">
              <label class="font-weight-bold">Общий объем средств, направленных на расходы жилого объекта: </label>
              {{ money.obsh_sred | toFixed}} рублей
            </div>

          </div>

          <div class="row mt-2">
            <div class="col">
              <label class="ml-2 font-weight-bold">
                1. Расходы на коммунальные услуги:
              </label>

              {{ money.rask }} рублей

            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                А. Водоснабжение (холодное, горячие, водоотведение)
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip5" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip5">
                    Начисленные за предыдущий
                    календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.voda"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Б. Тепловая энергия
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip6" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip6">
                    Начисленные за предыдущий
                    календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.tep"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                В. Природный газ
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip7" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip7">
                    Начисленные за предыдущий
                    календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.gaz"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Г. Электрическая энергия
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip8" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip8">
                    Начисленные за предыдущий
                    календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.elect"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <label class="ml-2 font-weight-bold">
                2. Расходы, связанные с содержанием имущества:
              </label>
              {{ money.rass | toFixed }} рублей

            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                А. Уборка территории
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip9" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip9">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.uborka_ter"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Б. Уборка помещений
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip10" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip10">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.uborka_pom"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                В. Техническое обслуживание
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip11" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip11">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.tech_obs"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Г. Дератизация, дезинсекция
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip12" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip12">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.derivation"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Д. Вывоз ТБО
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip13" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip13">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.tbo"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Е. Государственная поверка, паспортизация
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip14" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip14">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.gos_prov"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Ж. Проведение обследования технического состояния (аттестация)
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip15" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip15">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.attest"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                З. Противопожарные мероприятия
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip16" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip16">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.prot_pozhar"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                И. Иные расходы, связанные с содержанием имущества
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip17" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip17">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.inie_rash"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <label class="ml-2 font-weight-bold">
                3. Расходы на обеспечение безопасности проживания:
              </label>
              {{ money.rasb | toFixed}} рублей

            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                А. Услуги охраны
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip18" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip18">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.ohrana"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Б. Расходы в рамках антитеррористической защиты
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip19" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip19">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.anti_ter"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                В. Иные расходы, связанные с обеспечением безопасности
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip20" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip20">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.inie_rash_ohrana"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <label class="ml-2 font-weight-bold">
                4. Расходы на уплату налогов:
              </label>

              {{ money.rasn }} рублей
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                А. Налог на имущество
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip21" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip21">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.nalog_imush"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4">
                Б. Земельный налог
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip22" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip22">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.zem_nalog"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-2 font-weight-bold">
                5. Расходы на услуги связи
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip23" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip23">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.svaz"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-2 font-weight-bold">
                6. Расходы на капитальный ремонт
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip24" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip24">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.kap_rem"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-2 font-weight-bold">
                7. Расходы на текущий ремонт
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip25" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip25">
                    Начисленных за предыдущий календарный год,
                    включая заработную плату с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.tek_rem"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-2 font-weight-bold">
                8. Расходы на приобретение мягкого инвентаря и других материальных запасов
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip26" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip26">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.mygk_inv"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <label class="ml-2 font-weight-bold">
                9. Расходы на приобретение основных средств, в том числе мебели
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip27" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip27">
                    Начисленные за предыдущий календарный год
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.osn_sred"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-6">
              <label>
                Фонд оплаты труда
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip28" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip28">
                    Начисленных за предыдущий календарный год,
                    всех категорий сотрудников обслуживающих
                    жилой объект с начислениями
                  </b-tooltip>
                </template>
                <b-form-input step="0.001" type="number" v-model.number="currentObject.money.opla_trud"
                              :disabled="blockPage"/>
              </b-input-group>
            </div>
          </div>

          <stepper
              :back-url="user.isAdmin ?
          `/admin/objects-area/${id_org}/${$route.params.id_object}` :
          `/objects-area/${$route.params.id_object}`"
              :to-url="user.isAdmin ?
          `/admin/objects-tariff/${id_org}/${$route.params.id_object}` :
          `/objects-tariff/${$route.params.id_object}`"
              percent="60"
              end-button-label="Далее"
              @save-page="savePage"
          />
          <hr>
          <div class="text-center">
            <button class="btn btn-primary" type="button" @click="setZeros()">Заполнить нулями пустые поля</button>
          </div>
          <hr>
        </div>
        <loading v-else/>
      </div>
      <loading v-else/>
    </v-page>


    <scroll-button/>
  </div>
</template>

<script>
import {BAlert, BButton, BFormInput, BFormSelect, BInputGroup, BInputGroupText, BTooltip,} from 'bootstrap-vue';
import Axios from 'axios';
import scrollButton from '../../organisms/scrollButton';

import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import MoneyIcon from "../../organisms/moneyIcon";
import Loading from "../../organisms/loading";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";

export default {
  name: 'object_money',
  components: {
    VPage,
    Stepper,
    Loading,
    MoneyIcon,
    OrgSelect,
    scrollButton,
    BFormInput,
    BInputGroup,
    BFormSelect,
    BButton,
    BInputGroupText,
    BTooltip, BAlert,
  },
  watch: {
    async id_org() {
      if (this.componentReady)
        await this.getObject();
    },
    objects() {
      this.objectsTitle = this.objects.map((item, index) => ({
        value: index,
        text: `${item.name} [${item.kad_number}]`,
      }));
    },
    currentObject: {
      handler() {

        let toNum = num => typeof num === 'string' ? num.toNumber() : (!num ? 0 : num);

        this.money.obsh =
            toNum(this.currentObject.money.money_prozh_bez_dop) +
            toNum(this.currentObject.money.money_prozh_dop) +
            toNum(this.currentObject.money.money_aren) +
            toNum(this.currentObject.money.money_cel_sred);
        this.money.rask =
            toNum(this.currentObject.money.voda) +
            toNum(this.currentObject.money.tep) +
            toNum(this.currentObject.money.gaz) +
            toNum(this.currentObject.money.elect);

        this.money.rasb =
            toNum(this.currentObject.money.ohrana) +
            toNum(this.currentObject.money.anti_ter) +
            toNum(this.currentObject.money.inie_rash_ohrana);
        this.money.rasn =
            toNum(this.currentObject.money.nalog_imush) +
            toNum(this.currentObject.money.zem_nalog);

        this.money.rass =
            toNum(this.currentObject.money.uborka_ter) +
            toNum(this.currentObject.money.uborka_pom) +
            toNum(this.currentObject.money.tech_obs) +
            toNum(this.currentObject.money.derivation) +
            toNum(this.currentObject.money.tbo) +
            toNum(this.currentObject.money.gos_prov) +
            toNum(this.currentObject.money.attest) +
            toNum(this.currentObject.money.prot_pozhar) +
            toNum(this.currentObject.money.inie_rash);
        this.money.obsh_sred =
            toNum(this.money.rask) +
            toNum(this.money.rass) +
            toNum(this.money.rasb) +
            toNum(this.money.rasn) +
            toNum(this.currentObject.money.svaz) +
            toNum(this.currentObject.money.kap_rem) +
            toNum(this.currentObject.money.tek_rem) +
            toNum(this.currentObject.money.mygk_inv) +
            toNum(this.currentObject.money.osn_sred);
      },
      deep: true,
    },
  },
  methods: {
    fuckDecimals(value) {
      return value.replace(',', '.');
    },
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    setObject(index) {
      this.currentObject = this.objects.find((item, i) => i === index);
    },
    setZeros() {
      this.inputs.forEach(item => {
        if (this.isEmpty(this.currentObject.money[item]))
          this.currentObject.money[item] = 0;
      })
      this.$forceUpdate()

    },
    async getObject() {
      await Axios.get(`/api/objects/org/${this.id_org}/${this.$route.params.id_object}`).then((res) => {
        this.currentObject = res.data;
        if (!this.currentObject.money) {
          this.currentObject.money = {};
        }
      });
    },

    validate() {
      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];

        if (this.isEmpty(this.currentObject.money[item]))
          return false;
      }
      return true;
    },

    async savePage(validate, resolve) {

      if (validate && !this.validate()) {
        await this.$bvModal.msgBoxOk("Для сохранения необходимо заполнить пустые поля.");
        resolve(false)
        return;
      }

      const data = new FormData();
      data.append('money', JSON.stringify(this.currentObject.money));
      await Axios.post(`/object/set-money/${this.currentObject.id}`, data, {
        headers: {
          'X-CSRF-Token': this.csrf,
        },
      });
      resolve(true)
    },
  },
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin) this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    //this.blockPage = this.user.isAdmin;
    await this.getObject();
    this.componentReady = true;
  },
  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      blockPage: false,
      currentObject: null,
      inputs: [
        'money_prozh_bez_dop', 'money_prozh_dop', 'money_aren', 'money_cel_sred', 'voda', 'tep',
        'gaz', 'elect', 'uborka_ter', 'uborka_pom', 'tech_obs', 'derivation', 'tbo', 'gos_prov',
        'attest', 'prot_pozhar', 'inie_rash', 'ohrana', 'anti_ter', 'inie_rash_ohrana', 'nalog_imush',
        'zem_nalog', 'svaz', 'kap_rem', 'tek_rem', 'mygk_inv', 'osn_sred', 'opla_trud'
      ],
      money: {
        obsh: 0,
        obsh_sred: 0,
        rask: 0,
        rass: 0,
        rasb: 0,
        rasn: 0,
      },
      objectsTitle: [],
      componentReady: false,
      id_org: null,
      user: {},
      objects: [],
    };
  },
  mixins: [mainMixin]
};
</script>

<style scoped/>