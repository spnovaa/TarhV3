<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            app
            class="cyan darken-4"
            dark
            right
            src="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg"
        >
            <v-list-item>
                <v-list-item-avatar>
                    <v-img v-if="profile.profile_image" :src="'./images/'+profile.profile_image"></v-img>
                    <v-img v-else src='./images/welcome/profile.jpg'></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title style="text-align:right">{{ this.baseInfo.name }} {{ this.baseInfo.last_name }}
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list>
                <div v-if="profile.sent_flag==1 && profile.active==1 && profile.admin_accept==1">
                    <v-list-item v-for="item in items"
                                 :key="item.title" :to="item.route" link>
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title class="text-right" style="font-family:'Samim';">{{ item.title }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </div>
                <div
                    v-if="profile.active==2 ||(profile.sent_flag==1 && profile.admin_accept==0 && profile.active==0 ) ">
                    <v-list-item to="/profileShow">
                        <v-list-item-icon>
                            <v-icon>mdi-pencil-box-outline</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title class="text-right" style="font-family:'Samim';">{{title}}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </div>
                <div v-if="profile.sent_flag==0">
                    <v-list-item to="/editProfile">
                        <v-list-item-icon>
                            <v-icon>mdi-pencil-box-outline</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title class="text-right" style="font-family:'Samim';">{{title}}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </div>
            </v-list>

        </v-navigation-drawer>

        <v-app-bar app dark src="https://ak.picdn.net/shutterstock/videos/33743356/thumb/8.jpg">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>سامانه خوشه</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="black" dark fab small title="خروج" @click="logout">
                <v-icon>mdi-power</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <v-container class="fill-height grey lighten-2" fluid>
                <router-view :profile="profile"></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

    export default {
        created() {
            this.getBaseInfo();
            this.getProfile();
        },
        data: () => ({
            title: '',
            drawer: null,
            items: [
                // { title: 'داشبورد', icon: 'mdi-view-dashboard', route:'/dashboard' },
                {title: 'انبار', icon: 'mdi-store', route: '/safirInventory'},
                {title: 'پروفایل', icon: 'mdi-account', route: '/profileShow'},
                {title: 'ثبت فاکتور', icon: 'mdi-playlist-plus', route: '/sell'},
                {title: 'فاکتورها', icon: 'mdi-import', route: '/safirShowOrders'},
                {title: 'پیشخوان کتابفروش', icon: 'mdi-import', route: '/order'},
                // { title: 'درباره ما', icon: 'mdi-library', route:'/info' },
            ],
            baseInfo: {
                user_id: '',
                name: '',
                last_name: '',
                email: '',
                tel: '',
            },
            profile: {
                email: '',
                code: '',
                admin_accept: null,
                active: '',
                fathers_name: '',
                gender: '',
                national_id: '',
                tel: '',
                born_date: '',
                profile_image: '',
                living_address: '',
                living_state: '',
                living_city: '',
                living_area: '',
                living_street: '',
                living_alley: '',
                living_plaque: '',
                living_zip: '',
                educated_at: '',
                education_grade: '',
                education_city: '',
                education_branch: '',
                selling_background: '',
                book_background: '',
                last_read_3b: '',
                suggestion: '',
                moarref: '',
                payamresan: '',
                payamresan_phone: '',
                instagram: '',
                sent_flag: '',
                percentage: '',
                shabaID: '',
                sent_report: '',
                heyat_name: '',
                manager_name: '',
                manager_tel: '',
                heyat_address: '',
            },


        }),
        methods: {
            logout() {
                axios.post('/logout')
                    .then((response) => {
                        window.location.href = "login"
                    })
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
            getProfile() {
                axios.post('/getProfile')
                    .then((data) => {
                        if (data.data) {
                            this.profile = data.data;
                            if (data.data.sent_flag==="1")
                                this.title = 'مشاهده فرم ارسالی';
                            else
                                this.title = 'تکمیل ثبت نام';
                        }
                    })
                    .catch(() => {
                        this.logout();
                    });
            }
        }


    }
</script>
