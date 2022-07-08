<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <div v-if="profile.sent_resume==0">
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
                            <h5 v-if="profile.admin_accept==1 && profile.sent_resume==0 && profile.sent_resume==0"
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
                <v-row>
                    <v-col cols="12" md="6">
                        <v-card class="px-5 boxborder">
                            <div class="d-flex grow flex-wrap">
                                <v-sheet class="success mt-n5 mb-3" style="border-radius:4px">
                                    <v-icon class="ma-6" dark style="font-size:2.5em"> mdi-account</v-icon>
                                </v-sheet>
                                <v-card-title>
                                    اطلاعات فردی مسئول
                                </v-card-title>
                            </div>

                            <v-card-text>
                                <v-col>
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field v-model="profile.name" dense label=" نام "
                                                          outlined></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
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
                                        <v-col class="py-0" cols="12" md="6">
                                            <v-text-field v-model="profile.last_name" dense
                                                          label="نام خانوادگی " outlined></v-text-field>
                                        </v-col>

                                        <v-col class="py-0" cols="12" md="6">
                                            <v-text-field v-model="resume.national_id.val"
                                                          :class="{err : resume.national_id.err}"
                                                          :rules="[rules.required]"
                                                          dense
                                                          label="کد ملی" outlined></v-text-field>
                                        </v-col>
                                        <v-col class="py-0" cols="12">
                                            <v-text-field v-model="profile.company_name" dense disabled
                                                          label="نام شرکت" outlined></v-text-field>
                                        </v-col>
                                        <v-col class="py-0" cols="12">
                                            <v-row>
                                                <v-text-field v-model="resume.shabaID.val"
                                                              :class="{err : resume.shabaID.err}"
                                                              :rules="[rules.required]"
                                                              class="mx-3 number-input"
                                                              dense label="شماره شبا" outlined
                                                              @change="normalShaba"></v-text-field>
                                                <h1>IR</h1>
                                            </v-row>
                                        </v-col>

                                        <v-col class="py-0" cols="12">
                                            <v-text-field v-model="resume.credit_card.val"
                                                          :class="{err : resume.credit_card.err}"
                                                          :rules="[rules.required]"
                                                          dense
                                                          label="شماره کارت"
                                                          outlined @change="normalShaba"></v-text-field>
                                        </v-col>
                                    </v-row>

                                </v-col>
                            </v-card-text>
                        </v-card>
                    </v-col>
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

                                    <v-col class="text-right" cols="12">
                                        <h4> آدرس شرکت </h4>
                                    </v-col>

                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="profile.tel" dense disabled label="شماره موبایل"
                                                      outlined prepend-icon="mdi-cellphone">
                                        </v-text-field>
                                    </v-col>

                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="resume.company_tel.val"
                                                      :class="{err : resume.company_tel.err}"
                                                      :rules="[rules.required]"
                                                      dense
                                                      label="تلفن شرکت با پیش شماره" outlined
                                                      prepend-icon="mdi-phone">
                                        </v-text-field>
                                    </v-col>

                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="resume.living_state.val"
                                                      :class="{err : resume.living_state.err}"
                                                      :rules="[rules.required]"
                                                      dense
                                                      label="استان" outlined
                                                      prepend-icon="mdi-earth">
                                        </v-text-field>
                                    </v-col>

                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="resume.living_city.val"
                                                      :class="{err : resume.living_city.err}"
                                                      :rules="[rules.required]" class="required"
                                                      dense
                                                      label="شهر" outlined
                                                      prepend-icon="mdi-city">
                                        </v-text-field>
                                    </v-col>

                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="resume.living_area.val"
                                                      :class="{err : resume.living_area.err}" dense
                                                      hint="اختیاری"
                                                      label="محله" outlined persistent-hint
                                                      prepend-icon="mdi-pine-tree">
                                        </v-text-field>
                                    </v-col>

                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="resume.living_street.val"
                                                      :class="{err : resume.living_street.err}"
                                                      :rules="[rules.required]"
                                                      dense
                                                      label="خیابان" outlined
                                                      prepend-icon="mdi-traffic-light">
                                        </v-text-field>
                                    </v-col>

                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="resume.company_zip.val"
                                                      :class="{err : resume.company_zip.err}"
                                                      :rules="[rules.required]"
                                                      dense
                                                      label="کد پستی" outlined
                                                      prepend-icon="mdi-office-building-marker">
                                        </v-text-field>
                                    </v-col>

                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>

                </v-row>

                <v-snackbar v-model="error" bottom color="red darken-2" top>
                    {{ ErrMsg }}
                </v-snackbar>
                <v-snackbar v-model="success" bottom color="green darken-2" top>
                    {{ ErrMsg }}
                </v-snackbar>
                <div style="text-align:center">
                    <v-btn :disabled="isDisabled" class="primary mb-8" @click="Register">
                        <v-icon class="ma-2">mdi-upload</v-icon>
                        <v-divider style="border-color:#90CAF9" vertical></v-divider>
                        <span class="ma-2">
                            ارسال اطلاعات
                        </span>
                    </v-btn>
                </div>
            </v-form>
        </div>
        <div v-if="profile.sent_resume==1">
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

    // created(){
    //     this.getBaseInfo();
    // },

    data() {
        return {
            isDisabled: false,
            loading: false,
            error: false,
            success: false,
            ErrMsg: '',
            normalShabaStr: '',

            resume: {
                id: {val: '', req: 'required', err: false},
                name: {val: 'مصطفی', req: 'required', err: false},
                last_name: {val: 'رحمتی', req: 'required', err: false},
                company_name: {val: '', req: 'required', err: false},
                national_id: {val: '4610429802', req: 'required', err: false},
                shabaID: {val: '', req: 'required', err: false},
                credit_card: {val: '6037998144662797', req: 'required', err: false},
                tel: {val: '09211148982', req: 'required', err: false},
                company_tel: {val: '02112345678', req: 'required', err: false},
                profile_image: {val: [], req: 'required', err: false},
                living_state: {val: ']چهارمحال', req: 'required', err: false},
                living_city: {val: 'شهرکرد', req: 'required', err: false},
                living_area: {val: 'گودال چشمه', req: 'optional', err: false},
                living_street: {val: '13آبان', req: 'required', err: false},
                company_zip: {val: '13آبان', req: 'required', err: false},
            },
            baseInfo: {
                user_id: '',
                name: '',
                last_name: '',
                tel: '',
                company_name: '',
            },
            imgRules: {
                required: value => value.size > 0 || 'الزامی',
                size: value => (value.size <= 1000000) || 'حجم عکس پرسنلی نباید بیش از یک مگابایت باشد',
            },
            rules: {required: value => !!value || 'الزامی',},

        }
    },
    methods: {

        Register() {
            //this.isDisabled=true;
            this.resume.id.val = this.profile.id;
            this.resume.name.val = this.profile.name;
            this.resume.last_name.val = this.profile.last_name;
            this.resume.company_name.val = this.profile.company_name;
            this.resume.tel.val = this.profile.tel;

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
                fd.append('resumeImage', this.resume.profile_image.val, this.resume.profile_image.val.name);
                fd.append('resume', JSON.stringify(this.resume));

                axios.post('distributor/sendDistributorProfile', fd,
                    {headers: {'Content-Type': 'multipart/form-data'}}).then((response) => {
                    this.success = true;
                    this.ErrMsg = response.data;
                    setTimeout(this.refresh(), 50000);
                }).catch(() => {
                    alert('خطای سرور!')
                });

            }

        },

        refresh() {
            location.reload();
        },
        normalShaba() {
            this.normalShabaStr = this.resume.shabaID.val.replace(/[^0-9]/g, '');
            this.resume.shabaID.val = this.normalShabaStr;
        }
    },

}
</script>
