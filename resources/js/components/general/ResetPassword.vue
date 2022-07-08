<template>
    <v-app>
        <v-container class="book-background" fill-height fluid>
            <v-spacer></v-spacer>
            <v-col align="center" cols="10" justify="center" lg="3" md="4" sm="6">
                <v-card elevation="10" rounded="xl">
                    <v-card-text class="pt-8 px-0 pb-0 grey lighten-5" dark>
                        <v-form>
                            <v-icon class="my-2" color="success" x-large>mdi-lock-reset</v-icon>
                            <v-row align="center" class="mb-5 mt-0" justify="center">
                                <v-subheader>
                                    فراموشی کلمه عبور
                                </v-subheader>
                            </v-row>
                            <div v-if="!isMessageSent">
                                <v-row class="my-4">
                                    <v-text-field v-model="userData.phone" :rules="[telRules.required, telRules.min] " class="mx-8"
                                                  dense
                                                  hint="09xxxxxxxxx" label="شماره همراه"
                                                  maxlength=11 required
                                    ></v-text-field>
                                </v-row>
                                <v-row class="my-4">
                                    <v-text-field v-model="userData.nationalID" class="mx-8" dense
                                                  label="کد ملی"
                                    ></v-text-field>
                                </v-row>

                                <v-row class="mx-5 my-10">
                                    <v-subheader class="text-right" style="font-size: small">
                                        لطفا جهت دریافت کد تأیید، کد ملی و شماره همراهی را که
                                        با آن ثبت نام کرده اید را وارد نمایید.
                                    </v-subheader>
                                </v-row>
                            </div>

                            <div v-if="isMessageSent && !isCodeConfirmed" class="mx-5 my-10">
                                <v-subheader>
                                    لطفا کد ارسال شده برای شماره همراه خود را
                                    وارد نمایید.
                                </v-subheader>
                                <v-text-field v-model="userData.userEnteredCode" class="ma-5"
                                              label="کد تأیید"></v-text-field>
                            </div>
                            <div v-if="isMessageSent && isCodeConfirmed" class="mx-5 my-10">
                                <v-subheader>
                                    لطفا کلمه عبور جدید خود را وارد نمایید.
                                </v-subheader>
                                <v-text-field v-model="userData.password" :rules="[rules.required, rules.min]" class="ma-5"
                                              label="کلمه عبور"
                                ></v-text-field>
                            </div>
                            <div>
                            <span v-if="isCounterCounting">
                                {{ countDown }}
                                 ثانیه تا درخواست مجدد
                            </span>
                                <v-btn v-if="!isCounterCounting && isMessageSent" style="color: #3F51B5"
                                       text @click="resendCode">
                                    ارسال مجدد
                                </v-btn>
                            </div>
                            <v-btn :dark="!isButtonDisabled" :disabled="isButtonDisabled" block class="mt-10" color="teal darken-1" large
                                   tile
                                   @click="sendCode"
                            >
                            <span v-if="normalForm">
                                ارسال کد
                            </span>
                                <span v-if="isButtonLoading">
                                درحال ارسال
                                <v-progress-circular
                                    color="grey"
                                    indeterminate
                                    size="25"
                                ></v-progress-circular>
                            </span>
                                <span v-if="isMessageSent">
                                تایید
                            </span>

                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-spacer></v-spacer>
        </v-container>
    </v-app>
</template>

<script>
export default {
    name: "ResetPassword",
    data: () => ({
        userData: {
            nationalID: '',
            phone: '',
            userEnteredCode: '',
            password: ''
        },
        isRequestSent: false,
        isMessageSent: false,
        isButtonLoading: false,
        isCounterCounting: false,
        isCodeConfirmed: false,
        countDown: 120,

        rules: {
            required: value => !!value || 'الزامی',
            min: v => v.length >= 8 || 'حداقل 8 کاراکتر',
        },
        telRules: {
            required: value => !!value || 'الزامی',
            min: v => v.length >= 11 || ' تلفن همراه را بصورت کامل وارد کنید ',
        },

    }),
    computed: {
        normalForm() {
            return !(this.isRequestSent || this.isButtonLoading || this.isCounterCounting || this.isMessageSent)
        },
        isButtonDisabled() {
            return (this.isButtonLoading)
        }
    },
    methods: {
        countDownTimer() {
            this.isMessageSent = true;
            this.isCounterCounting = true;
            if (this.countDown > 0) {
                setTimeout(() => {
                    this.countDown -= 1
                    this.countDownTimer()
                }, 1000)
            } else {
                this.isCounterCounting = false;
            }
        },
        resendCode() {
            this.isMessageSent = false;
            this.sendCode();
        },
        async sendCode() {
            if (this.isButtonDisabled) return;
            if (!this.isMessageSent) {
                this.countDown = 120;
                this.isButtonLoading = true;
                this.requestCode()
                    .then((res) => {
                        if (res == 400) {
                            alert('اطلاعات وارد شده صحیح نیست');
                            this.isButtonLoading = false;
                            this.isMessageSent = false;
                            this.isRequestSent = false;
                            return;
                        }
                        console.log(res);
                        this.isButtonLoading = false;
                        this.isRequestSent = true;
                        this.isMessageSent = true;
                        this.countDownTimer();
                    });
            } else if (!this.isCodeConfirmed) {
                this.confirmCode()
                    .then((res) => {
                        if (res == 400) {
                            alert('اطلاعات وارد شده صحیح نیست');
                            return;
                        }
                        console.log(res);
                        if (res == 200) {
                            this.isCodeConfirmed = true;
                            this.isMessageSent = true;
                        }
                    });
            } else if (this.isCodeConfirmed) {
                this.resetPassword()
                    .then((res) => {
                        if (res == 400) {
                            alert('اطلاعات وارد شده صحیح نیست');
                            return;
                        }
                        console.log(res);
                        if (res == 200) {
                            alert('کلمه عبور با موفقیت تغییر پیدا کرد!');
                            window.location.replace("http://tarh.khooshe.org/login");
                        } else {
                            alert('تغییر کلمه عبور ناموفق بود');
                        }
                    });
            }
        },
        async requestCode() {
            try {
                let res = await axios({
                    url: './resetPasswordAskCode',
                    method: 'post',
                    timeout: 8000,
                    params: {
                        userData: this.userData
                    },

                })
                if (res.status == 200) {
                    // test for status you want, etc
                    console.log(res.status)
                }
                // Don't forget to return something
                return res.data
            } catch (err) {
                console.error(err);
            }
        },
        async confirmCode() {
            try {
                let res = await axios({
                    url: './resetPasswordConfirmCode',
                    method: 'post',
                    timeout: 8000,
                    params: {
                        userData: this.userData
                    },

                })
                if (res.status == 200) {
                    // test for status you want, etc
                    console.log(res.status)
                }
                // Don't forget to return something
                return res.data
            } catch (err) {
                console.error(err);
            }
        },
        async resetPassword() {
            try {
                let res = await axios({
                    url: './resetPassword',
                    method: 'post',
                    timeout: 8000,
                    params: {
                        userData: this.userData
                    },

                })
                if (res.status == 200) {
                    // test for status you want, etc
                    console.log(res.status)
                }
                // Don't forget to return something
                return res.data
            } catch (err) {
                console.error(err);
            }
        }
    },
    created() {
        console.log(this.$vuetify.breakpoint)
    }

}
</script>

<style scoped>
.book-background {
    background-image: url('/images/ui/backgrounds/natureBook.jpg');
    background-size: cover;
}
</style>
