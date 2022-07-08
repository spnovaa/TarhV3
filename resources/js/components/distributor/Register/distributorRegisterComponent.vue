<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" max-width="600px" persistent>

            <template v-slot:activator="{ on, attrs }">
                <v-btn v-bind="attrs" v-on="on" color="black" dark style="font-family:'Samim'">
                    <v-icon class="pl-2">mdi-account-plus</v-icon>
                    شرکت جدید
                </v-btn>
            </template>

            <v-card>

                <v-toolbar color="primary" dark>
                    <v-btn dark icon @click="dialog = false , error=null">
                        <v-icon>mdi-close-circle</v-icon>
                    </v-btn>
                    <v-toolbar-title>ثبت نام شرکت پخش در سامانه</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>

                <v-card-text>
                    <v-container>

                        <v-icon>mdi-key</v-icon>
                        <v-divider class="mx-4" vertical></v-divider>
                        <span>  لطفا اطلاعات خود را با دقت وارد نمایید    .</span>
                        <p v-if="error">
                            <br>
                            <v-icon style="color:red">mdi-alert-circle</v-icon>
                            <v-divider class="mx-4" vertical></v-divider>
                            <b style="color:red">لطفا تمامی اطلاعات خواسته شده را کامل کنید</b>
                        </p>
                        <v-row align="center" justify="center">
                            <v-col cols="12" md="5" sm="5">
                                <v-text-field v-model="tel" :rules="[telRules.required, telRules.min] "
                                              hint="09xxxxxxxxx"
                                              label="شماره تلفن همراه" maxlength=11 name="tel"
                                              required reverse type="text"></v-text-field>
                            </v-col>

                            <v-col cols="12" md="1" sm="1">
                                <v-icon>mdi-cellphone</v-icon>
                            </v-col>

                            <v-col cols="12" md="5" sm="5">
                                <v-text-field v-model="companyName" :rules="[rules.required]" label="نام شرکت"
                                              name="company_name" required reverse></v-text-field>
                            </v-col>

                            <v-col cols="12" md="1" sm="1">
                                <v-icon>mdi-shopping</v-icon>
                            </v-col>

                            <v-col cols="12" md="5" sm="5">
                                <v-text-field v-model="password"
                                              :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                              :rules="[rules.required, rules.min]"
                                              :type="show1 ? 'text' : 'password'"
                                              hint="حداقل 8 کاراکتر"
                                              label="گذرواژه" name="password"
                                              reverse
                                              @click:append="show1 = !show1"></v-text-field>
                            </v-col>


                            <v-col cols="12" md="1" sm="1">
                                <v-icon>mdi-account-key</v-icon>
                            </v-col>

                            <v-col cols="12" md="5" sm="5">
                                <v-text-field v-model="password_check"
                                              :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                              :rules="[rules.required, rules.min]"
                                              :type="show2 ? 'text' : 'password'" hint="حداقل 8 کاراکتر"
                                              label="ورود مجدد گذرواژه"
                                              name="password_check" required
                                              reverse
                                              @click:append="show2 = !show2"></v-text-field>
                            </v-col>

                            <v-col cols="12" md="1" sm="1">
                                <v-icon>mdi-account-check</v-icon>
                            </v-col>

                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn color="blue darken-1" text @click="dialog = false">
                        انصراف
                    </v-btn>

                    <v-btn color="blue darken-1" text @click="register">
                        ثبت
                    </v-btn>

                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>

</template>

<script>
export default {
    data: () => ({
        error: null,
        dialog: false,
        isvalid: false,
        companyName: null,
        password: null,
        password_check: null,
        tel: null,
        show1: false,
        show2: false,
        rules: {
            required: value => !!value || 'الزامی',
            min: v => v.length >= 8 || 'حداقل 8 کاراکتر',
        },

        telRules: {
            required: value => !!value || 'الزامی',
            min: v => v.length >= 11 || ' تلفن همراه را بصورت کامل وارد کنید ',
        },

    }),

    methods: {

        isMobile(e) {
            const value = event.target.value; // Get whole string
            let char = String.fromCharCode(e.keyCode); // Get the character
            if (/^[0-9]+$/.test(char) && String(value).length <= 10) return true; // Match with regex
            else e.preventDefault(); // If not match, don't add to input text
        },
        validate() {
            if (!this.companyName || !this.tel || !this.password || !this.password_check) {
                this.error = true;
                return null;
            }

            if (this.password === this.password_check) {
                axios({
                    method: 'post',
                    url: '/distributor/register',
                    data: {
                        companyName: this.companyName,
                        tel: this.tel,
                        password: this.password
                    }
                }).then((data) => {

                    alert(data.data);
                    this.dialog = false;
                    this.error = null;

                })

            } else {
                alert('پسورد مطابقت ندارد')
            }
        },
        register() {
            this.validate();
        }
    }

}
</script>
