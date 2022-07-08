<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <div v-if="profile.sent_flag==1">

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

                            <h5 v-if="profile.admin_accept==0 && profile.active==0 && profile.sent_flag==1"
                                style=" line-height:26pt">
                                اطلاعات شما توسط مدیریت درحال بررسی است.
                                نتیجه ی بررسی متعاقبا به اطلاع شما خواهد رسید.
                            </h5>

                            <h5 v-if="profile.active==1 && profile.admin_accept==1" style=" line-height:26pt">
                                اطلاعات شما توسط مدیریت بررسی و مورد تایید قرار گرفته است.
                                لطفا در صورت نیاز به تغییر اطلاعات فردی یا مشاهده ی هرگونه مغایرت، با پشتیبانی تماس
                                بگیرید.
                            </h5>

                            <h5 v-if="profile.active==2 && profile.admin_accept==0" style=" line-height:26pt">
                                اطلاعات کاربری شما مردود اعلام شده و یا حساب شما مسدود شده است.
                            </h5>
                            <h5 v-if="profile.active==1 && profile.admin_accept==0 && profile.sent_flag==1"
                                style=" line-height:26pt">
                                حساب کاربری شما تعلیق شده. جهت کسب اطلاعات بیشتر با پشتیبانی تماس بگیرید.
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
                                    <v-text-field v-model="profile.name" dense disabled label="نام"
                                                  outlined></v-text-field>
                                </v-col>

                                <v-col cols="6" md="4">
                                    <v-text-field v-model="profile.last_name" dense disabled label="نام خانوادگی"
                                                  outlined></v-text-field>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-avatar class="ml-4" size="96">
                                        <img :src="'./images/'+profile.profile_image" alt="Avatar">
                                    </v-avatar>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="6" md="2">
                                    <v-text-field v-model="profile.fathers_name" dense disabled label="نام پدر"
                                                  outlined></v-text-field>
                                </v-col>
                                <v-col cols="6" md="2">
                                    <v-text-field v-model="profile.national_id" dense disabled label="کد ملی"
                                                  outlined></v-text-field>
                                </v-col>
                                <v-col cols="6" md="2">
                                    <v-select v-model="profile.gender" :items="sex" dense disabled
                                              item-text="gen" item-value="code" label="جنسیت" menu-props="auto"
                                              outlined>
                                    </v-select>
                                </v-col>
                                <v-col cols="6" md="2">
                                    <v-row>
                                        <v-text-field id="my-custom-input" v-model="profile.born_date" dense disabled
                                                      label="تاریخ تولد" outlined></v-text-field>
                                    </v-row>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-row>
                                        <v-text-field v-model="profile.shabaID" class="mx-3" dense disabled
                                                      label="شماره شبا"
                                                      outlined></v-text-field>
                                        <h1>IR</h1>
                                    </v-row>

                                </v-col>
                            </v-row>
                        </v-col>
                    </v-card-text>
                </v-card>

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
                                        <v-text-field v-model="profile.tel" dense disabled label="شماره موبایل"
                                                      outlined prepend-icon="mdi-cellphone">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pt-0" cols="12">
                                        <v-text-field v-model="profile.email" dense disabled label="ایمیل"
                                                      outlined prepend-icon="mdi-email">
                                        </v-text-field>
                                    </v-col>
                                    <h4 class="pb-3">محل سکونت</h4>

                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="profile.living_state" dense disabled
                                                      label="استان" outlined prepend-icon="mdi-earth">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="profile.living_city" class="required" dense disabled
                                                      label="شهر" outlined prepend-icon="mdi-city">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="profile.living_street" dense disabled
                                                      label="خیابان" outlined
                                                      prepend-icon="mdi-traffic-light">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="profile.living_area" dense disabled
                                                      hint="اختیاری" label="محله" outlined persistent-hint
                                                      prepend-icon="mdi-pine-tree">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="profile.living_alley" dense disabled
                                                      label="کوچه" outlined
                                                      prepend-icon="mdi-deviantart">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="profile.living_plaque" dense disabled label="پلاک"
                                                      outlined prepend-icon="mdi-numeric">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="profile.living_zip" dense disabled label="کدپستی"
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

                                        <v-select v-model="profile.selling_background" :items="sellingYears"
                                                  dense
                                                  disabled item-text="time"
                                                  item-value="code"
                                                  label="چه مدت سابقه ی فروش کتاب دارید" menu-props="auto"
                                                  outlined>
                                        </v-select>

                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <h6 style="text-align:right">
                                            درصورتی که در حوزه کتاب فعالیتی داشته اید مختصرا ذکر کنید
                                        </h6>
                                        <v-textarea v-model="profile.book_background" class="mt-3" disabled
                                                    hint="اختیاری"
                                                    no-resize outlined persistent-hint
                                                    rows="3"></v-textarea>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <h6 style="text-align:right">
                                            نام سه کتابی که اخیرا مطالعه کردید چه بوده؟
                                        </h6>
                                        <v-textarea v-model="profile.last_read_3b" class="mt-3" disabled hint="اختیاری"
                                                    no-resize
                                                    outlined persistent-hint
                                                    rows="3"></v-textarea>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <h6 style="text-align:right">
                                            پیشنهاداتتان برای برگزاری هرچه بهتر طرح چیست؟
                                        </h6>
                                        <v-textarea v-model="profile.suggestion" class="mt-3" disabled hint="اختیاری"
                                                    no-resize outlined persistent-hint
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
                                        <v-select v-model="profile.education_grade" :items="grade" dense
                                                  disabled item-text="gr" item-value="code" label="مدرک تحصیلی"
                                                  menu-props="auto" outlined
                                        >
                                        </v-select>
                                    </v-col>
                                    <v-col class="py-0" cols="6">
                                        <v-text-field v-model="profile.education_branch" dense
                                                      disabled label="رشته"
                                                      outlined></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="profile.educated_at" dense
                                                      disabled label="دانشگاه/آموزشگاه"
                                                      outlined></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="profile.education_city" dense
                                                      disabled label="شهرتحصیل"
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
                                        <v-text-field v-model="profile.moarref"
                                                      dense disabled hint="اختیاری"
                                                      label="معرف شما جهت شرکت در طرح" outlined
                                                      persistent-hint></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="profile.payamresan"
                                                      dense disabled
                                                      hint="اختیاری"
                                                      label="در کدام پیامرسان فعالیت دارید؟" outlined
                                                      persistent-hint></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="profile.payamresan_phone"
                                                      dense disabled
                                                      hint="اختیاری"
                                                      label="شماره پیامرسان مذکور" outlined
                                                      persistent-hint></v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="profile.instagram"
                                                      dense disabled hint="اختیاری"
                                                      label="شناسه اینستاگرام" outlined
                                                      persistent-hint></v-text-field>
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
                                <v-text-field v-model="profile.heyat_name" dense
                                              disabled label="نام هیئت" outlined></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="12" md="4">
                                <v-text-field v-model="profile.manager_name" dense
                                              disabled label="نام مسئول هیئت"
                                              outlined></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="12" md="4">
                                <v-text-field v-model="profile.manager_tel" dense
                                              disabled label="شماره تماس مسئول هیئت"
                                              outlined></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="12">
                                <v-textarea v-model="profile.heyat_adress" disabled label="آدرس هیئت"
                                            no-resize outlined
                                            rows="3"></v-textarea>
                            </v-col>
                        </v-row>

                    </v-card-text>
                </v-card>

            </v-form>
        </div>
        <div v-else>
            <v-card>
                <v-card-text class="text-center">
                    کاربر گرامی لطفا از منو سمت راست نسبت به تکمیل اطلاعات خود اقدام فرمایید!
                </v-card-text>
            </v-card>
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

.success {
    box-shadow: 0 3px 5px -1px rgba(0, 0, 0, .2), 0 6px 10px 0 rgba(0, 0, 0, .14), 0 1px 18px 0 rgba(0, 0, 0, .12) !important;
}

.card {
    box-shadow: 0 3px 1px -2px rgba(0, 0, 0, .2), 0 2px 2px 0 rgba(0, 0, 0, .14), 0 1px 5px 0 rgba(0, 0, 0, .12) !important;
}

</style>

<script>
export default {
    props: ['profile'],

    data() {
        return {
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

        }
    },


}
</script>
