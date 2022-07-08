<template>
    <v-container>
        <div v-if="userType=='Admin'">
            <v-card>
                <v-card-text class="text-center">
                    مدیریت محترم خوش آمدید!
                </v-card-text>
            </v-card>
        </div>
        <div v-if="userType=='Shop'">
            <v-card>
                <v-card-text class="text-center">
                    کاربر گرامی لطفا از منو سمت راست نسبت به تکمیل اطلاعات خود اقدام فرمایید!
                </v-card-text>
            </v-card>
        </div>
        <div v-if="userType=='Safir'">
            <v-card>
                <v-card-text class="text-center">
                    کاربر گرامی لطفا از منو سمت راست نسبت به تکمیل اطلاعات خود اقدام فرمایید!
                </v-card-text>
            </v-card>
        </div>
        <div v-if="userType=='Dist'">
            <v-card>
                <v-card-text class="text-center">
                    کاربر گرامی لطفا از منو سمت راست نسبت به تکمیل اطلاعات خود اقدام فرمایید!
                </v-card-text>
            </v-card>
        </div>
    </v-container>

</template>


<script>
    export default {
        props: ['profile'],
        data: () => ({
            userType: '',
        }),
        created() {
            this.checkUserType()
        },
        methods: {
            checkUserType() {
                axios.post('/checkUserType')
                    .then((data) => {
                        this.userType = data.data
                        if (this.userType == "Admin") {
                            window.location.replace("/admin#/settings");
                        } else if (this.userType == "Dist") {
                            window.location.replace("/distributor#/distributorBooks");
                        } else if (this.userType == "Shop") {
                            window.location.replace("/shop#/shopProfileShow");
                        } else if (this.userType == "Safir") {
                            window.location.replace("/home#/safirInventory");
                        }
                    })
                    .catch(() => {
                        alert('خطا در ارتباط با سرور')
                    });
            }
        }
    }
</script>
