<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <v-card class=" mb-10" dark>
            <v-card-text style="text-align:right;">
                <v-row>
                    <v-col cols="3" style=" text-align:center; margin:auto">
                        <v-icon style="font-size:10vw; color:#FFB300">mdi-sync-alert</v-icon>
                    </v-col>
                    <v-col cols="1">
                        <v-divider vertical></v-divider>
                    </v-col>
                    <v-col cols="8">

                        <h5 style=" line-height:26pt">
                            لطفا در تغییر تنظیمات زیر بسیار دقت کنید. پس از اعمال تغییرات مد نظر، برای تایید از کلید
                            <span class="text--red">
                            ذخیره ی تغییرات
                        </span>
                            استفاده کنید.
                        </h5>

                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card class="px-5 boxborder">
            <div class="d-flex grow flex-wrap">
                <v-sheet class="success mt-n5 mb-3" style="border-radius:4px">
                    <v-icon class="ma-6"
                            dark style="font-size:2.5em"> mdi-cog-refresh
                    </v-icon>
                </v-sheet>
                <v-card-title>
                    تنظیمات طرح
                </v-card-title>
            </div>

            <v-card-text>
                <v-row>
                    <v-col cols="6" md="4">
                        <v-text-field v-model="settings.tarh_name" dense label="نام اصلی سامانه" outlined
                                      prepend-inner-icon="mdi-rename-box" @input="enableButton"></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-text-field v-model="settings.safir_tarh_name" dense label="نام طرح برای سفیر" outlined
                                      prepend-inner-icon="mdi-rename-box" @input="enableButton"></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-text-field v-model="settings.shop_tarh_name" dense label="نام طرح برای فروشگاه" outlined
                                      prepend-inner-icon="mdi-rename-box" @input="enableButton"></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-text-field v-model="settings.dist_tarh_name" dense label="نام طرح برای شرکت پخش" outlined
                                      prepend-inner-icon="mdi-rename-box" @input="enableButton"></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-text-field v-model.number="settings.safir_percentage" dense label="درصد پورسانت سفیر" outlined
                                      prepend-inner-icon="mdi-account-cash"
                                      suffix="درصد" type="number"
                                      @input="enableButton"></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-text-field v-model.number="settings.shop_percentage" dense label="درصد پورسانت فروشگاه "
                                      outlined prepend-inner-icon="mdi-shopping-outline"
                                      suffix="درصد" type="number"
                                      @input="enableButton"></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-text-field v-model.number="settings.dist_percentage" dense label="درصد پورسانت پخش " outlined
                                      prepend-inner-icon="mdi-account-tie"
                                      suffix="درصد" type="number"
                                      @input="enableButton"></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-text-field v-model.number="settings.customer_percentage" dense label="درصد تخفیف مشتری " outlined
                                      prepend-inner-icon="mdi-percent"
                                      suffix="درصد" type="number"
                                      @input="enableButton"></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-text-field v-model.number="settings.customer_percentage_limit" dense label="حداکثر تخفیف مشتری" outlined
                                      prepend-inner-icon="mdi-cash-lock"
                                      suffix="تومان" type="number"
                                      @input="enableButton"></v-text-field>
                    </v-col>
                </v-row>

                <v-divider></v-divider>

                <v-row align="center">
                    <v-col cols="12" md="4">
                        <v-checkbox
                            v-model="isSellCountLimited"
                            label="
                            تعداد جلد خریداری شده محدود باشد
                        "
                            @change="enableButton"
                        ></v-checkbox>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-if="isSellCountLimited"
                            v-model.number="settings.customer_buy_count_limit" dense label="تعداد کل خرید"
                            prepend-inner-icon="mdi-book"
                            suffix="جلد" type="number"
                            @input="enableButton"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-if="isSellCountLimited"
                            v-model.number="settings.customer_buy_count_limit_per_book" dense label="از هر عنوان"
                            prepend-inner-icon="mdi-book"
                            suffix="جلد" type="number"
                            @input="enableButton"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-divider></v-divider>
                <v-col cols="6" md="4">
                    <v-radio-group v-model="settings.can_shop_add_book" @change="enableButton">
                        <template v-slot:label>
                            <div class="text-right cyan--text  "><strong>امکان ثبت کتاب جدید برای فروشگاه</strong></div>
                        </template>
                        <v-row>
                            <v-radio label="
                                فعال
                                " value="1"></v-radio>
                            &nbsp;&nbsp;&nbsp;
                            <v-radio label="
                                    غیرفعال
                                " value="0"></v-radio>
                        </v-row>
                    </v-radio-group>
                </v-col>
                <v-divider></v-divider>
                <h4 class="text-right">
                    وضعیت طرح
                </h4>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="6" md="4">
                        <v-radio-group v-model="settings.safir_active" @change="enableButton">
                            <template v-slot:label>
                                <div class="text-right pink--text text--accent-3"><strong>- برای سفیران</strong></div>
                            </template>
                            <v-row>
                                <v-radio label="
                                فعال
                                " value="1"></v-radio>
                                &nbsp;&nbsp;&nbsp;
                                <v-radio label="
                                    غیرفعال
                                " value="0"></v-radio>
                            </v-row>
                        </v-radio-group>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-radio-group v-model="settings.shop_active" @change="enableButton">
                            <template v-slot:label>
                                <div class="text-right cyan--text  "><strong>- برای فروشگاه ها</strong></div>
                            </template>
                            <v-row>
                                <v-radio label="
                                فعال
                                " value="1"></v-radio>
                                &nbsp;&nbsp;&nbsp;
                                <v-radio label="
                                    غیرفعال
                                " value="0"></v-radio>
                            </v-row>
                        </v-radio-group>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-radio-group v-model="settings.dist_active" @change="enableButton">
                            <template v-slot:label>
                                <div class="text-right deep-orange--text "><strong>- برای پخش</strong></div>
                            </template>
                            <v-row>
                                <v-radio label="
                                فعال
                                " value="1"></v-radio>
                                &nbsp;&nbsp;&nbsp;
                                <v-radio label="
                                    غیرفعال
                                " value="0"></v-radio>
                            </v-row>
                        </v-radio-group>
                    </v-col>
                </v-row>
                <template>
                    <v-btn :disabled="disabled" class="mb-2 mr-2" color="success" dark @click.prevent="save">
                        <v-icon dark right>
                            mdi-content-save-settings-outline
                        </v-icon>
                        <span class="mr-2">
                            ذخیره تنظیمات
                        </span>
                    </v-btn>
                </template>
            </v-card-text>
        </v-card>
        <!--        <v-card>-->
        <!--            <template>-->
        <!--                <v-btn @click.prevent="getSafirStats" class="mb-2 mr-2" color="success" dark>-->
        <!--                    <v-icon dark right>-->
        <!--                        mdi-content-save-settings-outline-->
        <!--                    </v-icon>-->
        <!--                    <span class="mr-2">-->
        <!--                            خلاصه سفیران-->
        <!--                        </span>-->
        <!--                </v-btn>-->
        <!--            </template>-->
        <!--        </v-card>-->
        <v-snackbar v-model="error" bottom color="red darken-2" top>
            {{ ErrMsg }}
        </v-snackbar>
        <v-snackbar v-model="success" bottom color="green darken-2" top>
            {{ ErrMsg }}
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        error: false,
        success: false,
        ErrMsg: '',
        settings: '',
        disabled: true,
        isSellCountLimited: false,
    }),
    methods: {
        initialize() {
            axios.post('/admin/getSettings')
                .then((data) => {
                    this.settings = data.data;
                    this.settings.safir_active = this.settings.safir_active.toString()
                    this.settings.shop_active = this.settings.shop_active.toString()
                    this.settings.dist_active = this.settings.dist_active.toString()
                    this.settings.can_shop_add_book = this.settings.can_shop_add_book.toString()

                    if (data.data.customer_buy_count_limit > 0)
                        this.isSellCountLimited = true
                })
                .catch(() => {
                    alert('خطا در ارتباط با سرور')
                });
        },
        save() {

            if (!this.isSellCountLimited)
                this.settings.customer_buy_count_limit = 0;

            axios.post('/admin/saveSettings', this.settings)
                .then((data) => {
                    if (data.data == 'SUCCESS') {
                        this.disabled = true;
                        this.success = true
                        this.ErrMsg = 'تنظیمات با موفقیت به روزرسانی شد'
                    } else if (data.data == 'FAILURE') {
                        this.error = true
                        this.ErrMsg = 'به روزرسانی در سرور با اشکال مواجه شد'
                    }
                })
                .catch(() => {
                    alert('خطا در ارتباط با سرور')
                });
        },
        getSafirStats() {
            axios.post('/admin/getsafirStats')
                .then((data) => {
                    console.log(data)
                })
                .catch(() => {
                    alert('خطا در ارتباط با سرور')
                });
        },
        enableButton() {
            this.disabled = false
        }
    },
    created() {
        this.initialize();
    },

}
</script>

<style scoped>
.v-input--radio-group--column .v-radio:not(:last-child):not(:only-child) {
    margin-bottom: 0px !important;
}
</style>
