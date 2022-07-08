<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <div v-if="profile.sent_resume==1">
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
                            <h5 v-if="profile.admin_accept==0 && profile.dist_active==0 && profile.sent_resume==1"
                                style=" line-height:26pt">
                                اطلاعات شما توسط مدیریت درحال بررسی است.
                                نتیجه ی بررسی متعاقبا به اطلاع شما خواهد رسید.
                            </h5>

                            <h5 v-if="profile.dist_active==1 && profile.admin_accept==1" style=" line-height:26pt">
                                اطلاعات شما توسط مدیریت بررسی و مورد تایید قرار گرفته است.
                                لطفا در صورت نیاز به تغییر اطلاعات فردی یا مشاهده ی هرگونه مغایرت، با پشتیبانی تماس
                                بگیرید.
                            </h5>

                            <h5 v-if="profile.dist_active==2 && profile.admin_accept==0" style=" line-height:26pt">
                                اطلاعات کاربری شما مردود اعلام شده و یا حساب شما مسدود شده است.
                            </h5>
                            <h5 v-if="profile.dist_active==1 && profile.admin_accept==0 && profile.sent_resume==1"
                                style=" line-height:26pt">
                                حساب کاربری شما تعلیق شده. جهت کسب اطلاعات بیشتر با پشتیبانی تماس بگیرید.
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
                                    اطلاعات فردی
                                </v-card-title>
                            </div>

                            <v-card-text>
                                <v-col>
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field v-model="profile.name" dense disabled label="نام"
                                                          outlined></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-avatar class="ml-4" size="96">
                                                <img :src="'./images/distributors/'+profile.profile_image" alt="Avatar">
                                            </v-avatar>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field v-model="profile.last_name" dense disabled
                                                          label="نام خانوادگی" outlined></v-text-field>
                                        </v-col>

                                        <v-col cols="12" md="6">
                                            <v-text-field v-model="profile.national_id" dense disabled label="کد ملی"
                                                          outlined></v-text-field>
                                        </v-col>
                                        <v-col class="py-0" cols="12">
                                            <v-text-field v-model="profile.company_name" dense disabled
                                                          label="نام فروشگاه" outlined></v-text-field>
                                        </v-col>
                                        <v-col class="py-0" cols="12">
                                            <v-row>
                                                <v-text-field v-model="profile.shabaID" class="mx-3 number-input"
                                                              dense
                                                              disabled label="شماره شبا"
                                                              outlined></v-text-field>
                                                <h1>IR</h1>
                                            </v-row>

                                        </v-col>
                                        <v-col class="py-0" cols="12">
                                            <v-row>
                                                <v-text-field v-model="profile.credit_card" class="mx-3 number-input"
                                                              dense
                                                              disabled label="شماره کارت"
                                                              outlined></v-text-field>
                                            </v-row>
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

                                    <v-col class="text-right py-2" cols="12">
                                        <h4> آدرس شرکت </h4>
                                    </v-col>

                                    <v-col class="pb-0 pt-7" cols="12">
                                        <v-text-field v-model="profile.tel" dense disabled label="شماره موبایل"
                                                      outlined prepend-icon="mdi-cellphone">
                                        </v-text-field>
                                    </v-col>

                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="profile.company_tel" dense disabled label="تلفن"
                                                      outlined prepend-icon="mdi-phone">
                                        </v-text-field>
                                    </v-col>

                                    <v-col class="py-0" cols="12">
                                        <v-text-field v-model="profile.living_state" dense disabled
                                                      label="استان" outlined prepend-icon="mdi-earth">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="profile.living_city" class="required" dense disabled
                                                      label="شهر"
                                                      outlined prepend-icon="mdi-city">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="profile.living_area" dense disabled hint="اختیاری"
                                                      label="محله" outlined persistent-hint
                                                      prepend-icon="mdi-pine-tree">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="profile.living_street" dense disabled label="خیابان"
                                                      outlined prepend-icon="mdi-traffic-light">
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="py-0" cols="12" md="6">
                                        <v-text-field v-model="profile.company_zip" dense disabled label="کدپستی"
                                                      outlined prepend-icon="mdi-traffic-light">
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>

                </v-row>

            </v-form>
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
export default {

    props: ['profile'],


    data() {
        return {

            loading: false,

        }
    },
    methods: {

        logout() {
            axios.post('/logout')
                .then((response) => {
                    window.location.href = "login"
                })
        },

    },

}
</script>
