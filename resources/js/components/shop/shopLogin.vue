<template>
    <v-app style="font-family:Samim,sans-serif">

        <v-container class="book-background" fill-height fluid>
            <v-row>
                <v-col align="center" class="px-12" cols="11" justify="center" lg="4" md="5" sm="11">
                    <v-card elevation="10" max-width="350" rounded="xl">
                        <v-card-text class="pt-8 px-0 pb-0 grey lighten-5" dark>
                            <v-form>
                                <v-icon class="my-2" color="success" x-large>mdi-shield-key</v-icon>
                                <v-row align="center" class="mb-5 mt-0" justify="center">
                                    <div class="h5">
                                        ورود فروشگاه
                                    </div>
                                </v-row>

                                <v-row class="my-4">
                                    <v-text-field v-model="user.tel" :rules="[telRules.required, telRules.min]" autofocus
                                                  class="mx-12" dense
                                                  hint="09xxxxxxxxx"
                                                  label="شماره همراه" maxlength=11 persistent-placeholder required
                                    ></v-text-field>
                                </v-row>
                                <v-row class="my-4">
                                    <v-text-field id="password" v-model="user.pass" :rules="[rules.required, rules.min]" class="mx-12"
                                                  dense label="رمز عبور" persistent-placeholder
                                                  type="password"
                                    ></v-text-field>
                                </v-row>
                                <v-row class="mx-5 mb-2">
                                    <v-btn
                                        href="/resetPassword"
                                        text
                                    >
                                        <span style="font-size: small">
                                        <v-icon class="pl-2">mdi-lock-reset</v-icon>
                                        فراموشی رمز عبور
                                        </span>
                                    </v-btn>
                                </v-row>
                                <v-row class="mb-4 mx-8">
                                    <shop-register-component></shop-register-component>
                                </v-row>

                                <v-row class="mx-5 mt-10">
                                    <v-col cols="4">
                                        <v-img
                                            contain
                                            max-height="50"
                                            max-width="50"
                                            src="/images/neshan.jpeg"
                                        ></v-img>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-img
                                            contain
                                            max-height="50"
                                            max-width="50"
                                            src="/images/khooshe.png"
                                        ></v-img>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-img
                                            contain
                                            max-height="50"
                                            max-width="50"
                                            src="http://media.shabestan.ir/larg/1400/09/08/IMG11383142.jpg"
                                        ></v-img>
                                    </v-col>
                                </v-row>

                                <v-btn block class="mt-5" color="teal darken-1" dark large tile
                                       @click="login">
                                        <span>
                                            ورود
                                        </span>
                                </v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-spacer></v-spacer>
                <v-col class="d-none d-md-block" cols="5">
                    <v-carousel
                        :show-arrows="false"
                        class="mt-10"
                        cycle
                        delimiter-icon="mdi-minus"
                        elevation="12"
                        height="400"
                        hide-delimiter-background
                        show-arrows-on-hover
                    >
                        <v-carousel-item
                            v-for="(slide, i) in slides"
                            :key="i"
                            :src="slide.src"
                        >
                        </v-carousel-item>
                    </v-carousel>

                </v-col>
                <v-spacer></v-spacer>
            </v-row>
            <v-row align="center" justify="center">
                <v-btn dark href="tel: 02166123090" text>
                    <v-icon class="mx-2" type="button" >mdi-face-agent</v-icon>
                    پشتیبانی:
                    02166123090
                </v-btn>

            </v-row>
            <v-snackbar v-model="error" bottom color="red darken-2" top>
                <div align="center" justify="center">
                    <v-icon right>mdi-comment-alert-outline</v-icon>
                    <span class="ml-2">{{ ErrMsg }}</span>
                </div>
            </v-snackbar>
            <v-snackbar v-model="success" bottom color="green darken-2" top>
                <div align="center" justify="center">
                    <v-icon right> mdi-comment-check-outline</v-icon>
                    <span class="ml-2">{{ ErrMsg }}</span>
                </div>
            </v-snackbar>
        </v-container>
    </v-app>
</template>

<script>
export default {
    data: () => ({
        error: false,
        success: false,
        ErrMsg:'',
        user:{
            tel:'',
            pass:''
        },

        slides: [
            {
                src: '/images/temp_backg.jpg'
            }
        ],
        rules: {
            required: value => !!value || 'الزامی',
            min: v => (v && v.length >= 8) || 'حداقل 8 کاراکتر',
        },
        telRules: {
            required: value => !!value || 'الزامی',
            min: v => (v && v.length >= 11) || ' تلفن همراه را بصورت کامل وارد کنید ',
        }
    }),

    methods: {
        async login() {
            try {
                let res = await axios({
                    url: '/shop/login',
                    method: 'post',
                    timeout: 8000,
                    params: {
                        tel: this.user.tel,
                        password: this.user.pass
                    }
                })
                if (res.status === 200 || res.status === 204) {
                    this.ErrMsg = 'خوش آمدید';
                    this.success = true;
                    location.reload();
                }
                else {
                    this.ErrMsg = 'اطلاعات وارد شده صحیح نیست';
                    this.error = true;
                }
            } catch (err) {
                this.ErrMsg = 'اطلاعات وارد شده صحیح نیست';
                this.error = true;
            }
        }

    }

}
</script>

<style scoped>
.book-background {
    background-image: url('/images/ui/backgrounds/natureBook.jpg');
    background-size: cover;
}
</style>
