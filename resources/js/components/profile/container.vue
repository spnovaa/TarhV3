<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <div v-if="profile.sent_flag==0">
            <v-card class=" mb-10" dark>
                <v-card-text style="text-align:right;">
                    <v-row>
                        <v-col cols="3" style=" text-align:center; margin:auto">
                            <v-icon style="font-size:10vw; color:#FFB300">mdi-alert</v-icon>
                        </v-col>
                        <v-col cols="1">
                            <v-divider vertical></v-divider>
                        </v-col>
                        <v-col cols="8">
                            <h5 v-if="profile.admin_accept==1 && profile.sent_flag==0 && profile.sent_flag==0"
                                style=" line-height:26pt">
                                اطلاعات ارسالی شما از طرف مدیریت ناقص یا اشتباه تشخیص داده شد.
                                لطفا برای ثبت نام مجددا نسبت به تکمیل پرونده اقدام فرمایید.
                            </h5>
                            <h5 v-else style=" line-height:26pt">
                                ضمن قدردانی از ثبت نام اولیه ی شما، برای دسترسی به سایر بخش های سامانه
                                لازم است که اطلاعات خواسته شده در فرم زیر را تکمیل بفرمایید. پس از ارسال،
                                فرم، اطلاعات شما توسط مدیریت، بررسی و نتیجه ی آن از طریق پیامک
                                و همچنین بخش داشبورد به اطلاع شما خواهد رسید.
                            </h5>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-form>
                <v-card class="px-5 my-7 boxborder">
                    <div class="d-flex grow flex-wrap">
                        <v-sheet class="success mt-n5 mb-3" style="border-radius:4px">
                            <v-icon class="ma-6" dark style="font-size:2.5em"> mdi-account</v-icon>
                        </v-sheet>
                        <v-card-title>
                            اطلاعات فردی
                        </v-card-title>
                    </div>

                    <v-card-text>
                        <v-col>
                            <v-row>
                                <v-col cols="5" md="3">
                                    <v-text-field v-model="baseInfo.name" dense disabled label="نام"
                                                  outlined></v-text-field>
                                </v-col>

                                <v-col cols="6" md="4">
                                    <v-text-field v-model="baseInfo.last_name" dense disabled label="نام خانوادگی"
                                                  outlined></v-text-field>
                                </v-col>
                                <v-col v-if="!alreadyHasImage" cols="12" md="4">
                                    <v-file-input v-model="resume.profile_image.val"
                                                  :class="{err : resume.profile_image.err}"
                                                  :rules="[imgRules.required, imgRules.size]"
                                                  accept="image/png, image/jpeg, image/bmp"
                                                  dense
                                                  label="عکس پرسنلی"
                                                  outlined
                                                  placeholder="عکس پرسنلی"
                                                  prepend-icon="mdi-camera"
                                    ></v-file-input>

                                </v-col>
                                <v-col v-else cols="12" md="4">
                                    <v-avatar class="ml-4" size="96">
                                        <img :src="'./images/'+profile.profile_image" alt="Avatar">
                                    </v-avatar>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="6" md="2">
                                    <v-text-field v-model="resume.fathers_name.val" :class="{err : resume.fathers_name.err}"
                                                  :rules="[rules.required]"
                                                  dense
                                                  label="نام پدر" outlined></v-text-field>
                                </v-col>
                                <v-col cols="6" md="2">
                                    <v-text-field v-model="resume.national_id.val" :class="{err : resume.national_id.err}"
                                                  :rules="[rules.required]"
                                                  dense
                                                  label="کد ملی" outlined></v-text-field>
                                </v-col>
                                <v-col cols="6" md="2">
                                    <v-select v-model="resume.gender.val" :class="{err : resume.gender.err}" :items="sex"
                                              :rules="[rules.required]"
                                              dense item-text="gen" item-value="code"
                                              label="جنسیت" outlined>
                                    </v-select>
                                </v-col>
                                <v-col cols="6" md="2">
                                    <v-row>
                                        <v-text-field id="my-custom-input" v-model="resume.born_date.val"
                                                      :class="{err : resume.born_date.err}" :rules="[rules.required]"
                                                      dense label="تاریخ تولد"
                                                      outlined></v-text-field>
                                        <v-btn class="mr-n10" dark fab small>
                                            <v-icon id="my-custom-input">mdi-calendar</v-icon>
                                        </v-btn>
                                    </v-row>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-row>
                                        <v-text-field v-model="resume.shabaID.val" :class="{err : resume.shabaID.err}"
                                                      :rules="[rules.required]"
                                                      class="mx-3 number-input" dense
                                                      label="شماره شبا" outlined
                                                      @change="normalShaba"></v-text-field>
                                        <h1>IR</h1>
                                    </v-row>

                                </v-col>
                            </v-row>

                        </v-col>
                    </v-card-text>
                </v-card>
                <date-picker v-model="resume.born_date.val" element="my-custom-input"></date-picker>

                <v-row>
                    <v-col cols="12" md="6">
                        <v-card class="pa-8 boxborder">
                            <div class="d-flex grow flex-wrap mr-n4">
                                <v-sheet class="success mt-n13 mb-3" style="border-radius:4px">
                                    <v-icon class="ma-6" dark style="font-size:2.5em">mdi-map-marker-radius</v-icon>
                                </v-sheet>
                                <v-card-title class="mt-n10">
                                    اطلاعات تماس
                                </v-card-title>
                            </div>
                            <v-card-text>
                                <v-row>
                                    <v-col class="pb-0" cols="12">
                                        <v-text-field v-model="baseInfo.tel" dense disabled label="شماره موبایل"
                                                      outlined prepend-icon="mdi-cellphone">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pt-0" cols="12">
                                        <v-text-field v-model="baseInfo.email" dense disabled label="ایمیل"
                                                      outlined prepend-icon="mdi-email">
                                        </v-text-field>
                                    </v-col>
                                    <h4 class="pb-3">محل سکونت</h4>

                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="resume.living_state.val" :class="{err : resume.living_state.err}"
                                                      :rules="[rules.required]"
                                                      dense
                                                      label="استان" outlined
                                                      prepend-icon="mdi-earth">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="resume.living_city.val" :class="{err : resume.living_city.err}"
                                                      :rules="[rules.required]" class="required"
                                                      dense
                                                      label="شهر" outlined
                                                      prepend-icon="mdi-city">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="resume.living_street.val"
                                                      :class="{err : resume.living_street.err}" :rules="[rules.required]"
                                                      dense
                                                      label="خیابان" outlined
                                                      prepend-icon="mdi-traffic-light">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="resume.living_area.val" :class="{err : resume.living_area.err}" dense
                                                      hint="اختیاری"
                                                      label="محله" outlined persistent-hint
                                                      prepend-icon="mdi-pine-tree">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="resume.living_alley.val" :class="{err : resume.living_alley.err}"
                                                      :rules="[rules.required]"
                                                      dense
                                                      label="کوچه" outlined
                                                      prepend-icon="mdi-deviantart">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="resume.living_plaque.val"
                                                      :class="{err : resume.living_plaque.err}" :rules="[rules.required]" dense
                                                      label="پلاک"
                                                      outlined prepend-icon="mdi-numeric">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="resume.living_zip.val" :class="{err : resume.living_zip.err}"
                                                      :rules="[rules.required]" dense
                                                      label="کدپستی"
                                                      outlined prepend-icon="mdi-vector-point">
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="6">

                        <v-card class="pa-8 boxborder">
                            <div class="d-flex grow flex-wrap mr-n4">
                                <v-sheet class="success mt-n13 mb-3" style="border-radius:4px">
                                    <v-icon class="ma-6" dark style="font-size:2.5em">mdi-folder-account</v-icon>
                                </v-sheet>
                                <v-card-title class="mt-n10">
                                    سوابق
                                </v-card-title>
                            </div>
                            <v-card-text>
                                <v-row>
                                    <v-col class="py-0" cols="12">

                                        <v-select v-model="resume.selling_background.val" :class="{err : resume.selling_background.err}"
                                                  :items="sellingYears"
                                                  :rules="[rules.required]" dense item-text="time"
                                                  item-value="code" label="چه مدت سابقه ی فروش کتاب دارید"
                                                  outlined
                                        >
                                        </v-select>

                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <h6 style="text-align:right">
                                            درصورتی که در حوزه کتاب فعالیتی داشته اید مختصرا ذکر کنید
                                        </h6>
                                        <v-textarea v-model="resume.book_background.val" :class="{err : resume.book_background.err}"
                                                    class="mt-3" hint="اختیاری"
                                                    no-resize
                                                    outlined persistent-hint
                                                    rows="3"></v-textarea>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <h6 style="text-align:right">
                                            نام سه کتابی که اخیرا مطالعه کردید چه بوده؟
                                        </h6>
                                        <v-textarea v-model="resume.last_read_3b.val" :class="{err : resume.last_read_3b.err}" class="mt-3"
                                                    hint="اختیاری"
                                                    no-resize
                                                    outlined persistent-hint
                                                    rows="3"></v-textarea>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <h6 style="text-align:right">
                                            پیشنهاداتتان برای برگزاری هرچه بهتر طرح چیست؟
                                        </h6>
                                        <v-textarea v-model="resume.suggestion.val" :class="{err : resume.suggestion.err}" class="mt-3"
                                                    hint="اختیاری"
                                                    no-resize
                                                    outlined persistent-hint
                                                    rows="3"></v-textarea>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>

                    </v-col>
                    <v-col class="mt-2" cols="12" md="6">
                        <v-card class="mt-4 pa-8 boxborder">
                            <div class="d-flex grow flex-wrap mr-n4">
                                <v-sheet class="success mt-n13 mb-3" style="border-radius:4px">
                                    <v-icon class="ma-6" dark style="font-size:2.5em">mdi-book</v-icon>
                                </v-sheet>
                                <v-card-title class="mt-n10">
                                    اطلاعات تحصیلی
                                </v-card-title>
                            </div>
                            <v-card-text>
                                <v-row>
                                    <v-col class="py-0" cols="6">
                                        <v-select v-model="resume.education_grade.val" :class="{err : resume.education_grade.err}"
                                                  :items="grade"
                                                  :rules="[rules.required]" dense item-text="gr" item-value="code"
                                                  label="مدرک تحصیلی"
                                                  outlined>
                                        </v-select>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="resume.education_branch.val"
                                                      :class="{err : resume.education_branch.err}"
                                                      :rules="[rules.required]" dense
                                                      label="رشته"
                                                      outlined></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="resume.educated_at.val" :class="{err : resume.educated_at.err}"
                                                      :rules="[rules.required]" dense
                                                      label="دانشگاه/آموزشگاه"
                                                      outlined></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="resume.education_city.val"
                                                      :class="{err : resume.education_city.err}" :rules="[rules.required]"
                                                      dense label="شهرتحصیل"
                                                      outlined></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col class="mt-2" cols="12" md="6">
                        <v-card class="mt-4 pa-8 boxborder">
                            <div class="d-flex grow flex-wrap mr-n4">
                                <v-sheet class="success mt-n13 mb-3" style="border-radius:4px">
                                    <v-icon class="ma-6" dark style="font-size:2.5em">mdi-whatsapp</v-icon>
                                </v-sheet>
                                <v-card-title class="mt-n10">
                                    سایر موارد
                                </v-card-title>
                            </div>
                            <v-card-text>
                                <v-row>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="resume.moarref.val" :class="{err : resume.moarref.err}"
                                                      dense hint="اختیاری"
                                                      label="معرف شما جهت شرکت در طرح"
                                                      outlined persistent-hint></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="resume.payamresan.val" :class="{err : resume.payamresan.err}"
                                                      dense hint="اختیاری"
                                                      label="در کدام پیامرسان فعالیت دارید؟"
                                                      outlined persistent-hint></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="resume.payamresan_phone.val" :class="{err : resume.payamresan_phone.err}"
                                                      dense hint="اختیاری"
                                                      label="شماره پیامرسان مذکور"
                                                      outlined
                                                      persistent-hint></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="resume.instagram.val" :class="{err : resume.instagram.err}"
                                                      dense hint="اختیاری" label="شناسه اینستاگرام"
                                                      outlined persistent-hint></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <v-card class="px-5 my-5 boxborder">
                    <v-card-title>اطلاعات هیئت</v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col class="py-0" cols="12" md="4">
                                <v-text-field v-model="resume.heyat_name.val" :class="{err : resume.heyat_name.err}" :rules="[rules.required]"
                                              dense label="نام هیئت"
                                              outlined></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="12" md="4">
                                <v-text-field v-model="resume.manager_name.val" :class="{err : resume.manager_name.err}"
                                              :rules="[rules.required]" dense label="نام مسئول هیئت"
                                              outlined></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="12" md="4">
                                <v-text-field v-model="resume.manager_tel.val" :class="{err : resume.manager_tel.err}"
                                              :rules="[rules.required]" dense label="شماره تماس مسئول هیئت"
                                              outlined></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="12">
                                <v-textarea v-model="resume.heyat_adress.val" :class="{err : resume.heyat_adress.err}"
                                            :rules="[rules.required]"
                                            label="آدرس هیئت" no-resize outlined
                                            rows="3"></v-textarea>
                            </v-col>
                        </v-row>

                    </v-card-text>
                </v-card>

                <v-snackbar v-model="error" bottom color="red darken-2" top>
                    {{ErrMsg}}
                </v-snackbar>
                <v-snackbar v-model="success" bottom color="green darken-2" top>
                    {{ErrMsg}}
                </v-snackbar>
                <div style="text-align:center">
                    <v-btn :disabled="isDisabled" class="primary mb-8" @click="Register">
                        <v-icon class="ma-2">mdi-upload</v-icon>
                        <v-divider style="border-color:#90CAF9" vertical></v-divider>
                        <span class="ma-2">
                            ارسال فرم
                        </span>
                    </v-btn>
                </div>
            </v-form>
        </div>
        <div v-if="profile.sent_flag==1">
            <v-row>
                <v-spacer></v-spacer>
                <v-col cols="12" md="8">
                    <v-card class="ma-8 boxborder" style=" text-align:center; margin:auto">
                        <v-card-text>
                            به سامانه خوشه خوش آمدید.
                        </v-card-text>

                    </v-card>
                </v-col>
                <v-spacer></v-spacer>
            </v-row>
        </div>
    </v-container>

</template>

<style>
    .err .v-input__control .v-input__slot fieldset {
        color: red !important;
    }

    .v-list-item__title {

        justify-content: right !important;
        text-align: right !important;
        display: grid !important;

    }

    .number-input input {
        direction: ltr !important;
    }

    .success {
        box-shadow: 0 3px 5px -1px rgba(0, 0, 0, .2), 0 6px 10px 0 rgba(0, 0, 0, .14), 0 1px 18px 0 rgba(0, 0, 0, .12) !important;
    }

    .card {
        box-shadow: 0 3px 1px -2px rgba(0, 0, 0, .2), 0 2px 2px 0 rgba(0, 0, 0, .14), 0 1px 5px 0 rgba(0, 0, 0, .12) !important;
    }

</style>

<script>
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker'

    export default {

        props: ['profile'],

        created() {
            this.getBaseInfo();
            this.getProfile();
        },

        data() {
            return {
                alreadyHasImage: false,
                nationalCheck: false,
                isDisabled: false,
                loading: false,
                error: false,
                success: false,
                ErrMsg: '',
                normalShabaStr: '',
                sellingYears: [
                    {code: 1, time: 'ندارم'},
                    {code: 2, time: 'کمتر از 2 سال'},
                    {code: 3, time: 'بین 2 تا 5 سال'},
                    {code: 4, time: 'بیش از 5 سال'},
                ],
                sex: [
                    {code: 1, gen: 'آقا'},
                    {code: 2, gen: 'خانم'},
                ],
                grade: [
                    {code: 1, gr: 'زیردیپلم'},
                    {code: 2, gr: 'دیپلم'},
                    {code: 3, gr: 'کاردانی'},
                    {code: 4, gr: 'کارشناسی'},
                    {code: 5, gr: 'کارشناسی ارشد'},
                    {code: 6, gr: 'دکترا'},
                ],

                resume: {
                    name: {val: '', req: 'required', err: false},
                    last_name: {val: '', req: 'required', err: false},
                    email: {val: '', req: 'required', err: false},
                    fathers_name: {val: '', req: 'required', err: false},
                    gender: {val: '', req: 'required', err: false},
                    national_id: {val: '', req: 'required', err: false},
                    shabaID: {val: '', req: 'required', err: false},
                    tel: {val: '', req: 'required', err: false},
                    born_date: {val: '', req: 'required', err: false},
                    profile_image: {val: [], req: 'required', err: false},
                    living_state: {val: '', req: 'required', err: false},
                    living_city: {val: '', req: 'required', err: false},
                    living_area: {val: '', req: 'optional', err: false},
                    living_street: {val: '', req: 'required', err: false},
                    living_alley: {val: '', req: 'required', err: false},
                    living_plaque: {val: '', req: 'required', err: false},
                    living_zip: {val: '', req: 'required', err: false},
                    educated_at: {val: '', req: 'required', err: false},
                    education_grade: {val: '', req: 'required', err: false},
                    education_city: {val: '', req: 'required', err: false},
                    education_branch: {val: '', req: 'required', err: false},
                    selling_background: {val: '', req: 'required', err: false},
                    book_background: {val: '', req: 'optional', err: false},
                    last_read_3b: {val: '', req: 'optional', err: false},
                    suggestion: {val: '', req: 'optional', err: false},
                    moarref: {val: '', req: 'optional', err: false},
                    payamresan: {val: '', req: 'optional', err: false},
                    payamresan_phone: {val: '', req: 'optional', err: false},
                    instagram: {val: '', req: 'optional', err: false},
                    heyat_name: {val: '', req: 'required', err: false},
                    manager_name: {val: '', req: 'required', err: false},
                    manager_tel: {val: '', req: 'required', err: false},
                    heyat_adress: {val: '', req: 'required', err: false}
                },
                baseInfo: {
                    user_id: '',
                    name: '',
                    last_name: '',
                    email: '',
                    tel: '',
                },
                imgRules: {
                    required: value => value.size > 0 || 'الزامی',
                    size: value => (value.size <= 1000000) || 'حجم عکس پرسنلی نباید بیش از یک مگابایت باشد',
                },
                rules: {required: value => !!value || 'الزامی',},

            }
        },
        components: {
            datePicker: VuePersianDatetimePicker
        },
        methods: {

            Register() {

                this.isDisabled = true;
                this.resume.name.val = this.baseInfo.name;
                this.resume.last_name.val = this.baseInfo.last_name;
                this.resume.email.val = this.baseInfo.email;
                this.resume.tel.val = this.baseInfo.tel;
                for (const property in this.resume) {
                    if ((this.resume[property].val.length == 0 || this.resume[property].val == 0) && this.resume[property].req == 'required') {
                        this.resume[property].err = true;
                        this.ErrMsg = "لطفا تمامی فیلدهای الزامی را مطابق آنچه خواسته شده تکمیل فرمایید"
                        this.error = true;
                        this.isDisabled = false;

                    } else {
                        this.resume[property].err = false;
                    }
                }
                if (!this.error) {

                    const fd = new FormData();
                    if (!this.alreadyHasImage)
                        fd.append('resumeImage', this.resume.profile_image.val, this.resume.profile_image.val.name);
                    fd.append('resume', JSON.stringify(this.resume));

                    axios.post('/sendProfile', fd, {headers: {'Content-Type': 'multipart/form-data'}}).then((response) => {
                        if (response.data == "WRNGCD") {
                            this.error = true;
                            this.ErrMsg = "کد ملی وارد شده صحیح نیست!";
                            this.isDisabled = false
                        } else {
                            this.success = true;
                            this.ErrMsg = response.data;
                            setTimeout(this.refresh(), 12000);
                        }

                    }).catch(() => {
                        alert('خطای سرور!')
                    });

                }

            },
            getBaseInfo() {
                axios.post('/getBaseInfo')
                    .then((data) => {
                        if (data.data) {
                            this.baseInfo.user_id = data.data.id;
                            this.baseInfo.name = data.data.name;
                            this.baseInfo.last_name = data.data.last_name;
                            this.baseInfo.email = data.data.email;
                            this.baseInfo.tel = data.data.tel;
                        }
                    })
                    .catch(() => {
                        this.logout();
                    });
            },
            logout() {
                axios.post('/logout')
                    .then((response) => {
                        window.location.href = "login"
                    })
            },
            normalShaba() {
                this.normalShabaStr = this.resume.shabaID.val.replace(/[^0-9]/g, '');
                this.resume.shabaID.val = this.normalShabaStr;
            },
            refresh() {
                location.reload();
            },
            getProfile() {
                axios.post('/getProfile')
                    .then((data) => {
                        if (data.data) {
                            let prof = data.data;
                            for (const [profKey, profValue] of Object.entries(prof)) {
                                for (const [resKey, resValue] of Object.entries(this.resume)) {
                                    if(profKey===resKey && profValue && profValue.length>0) {
                                        this.resume[resKey].val = profValue;
                                        if (resKey === 'profile_image' && profValue && profValue.length>0) this.alreadyHasImage = true;
                                    }
                                }
                            }
                        }
                    })
                    .catch((e) => {
                        console.log(e)
                    });
            }
        },

    }
</script>
