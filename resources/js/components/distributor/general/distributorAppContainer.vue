<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app class="cyan darken-4" dark
                             right src="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg">
            <v-list-item>
                <v-list-item-avatar style="background-color:white;">
                    <v-img v-if="profile.profile_image" :src="'./images/distributors/'+profile.profile_image"></v-img>
                    <v-img v-else src="./images/khooshe.png"></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title style="text-align:right">
                        شرکت
                        {{ profile.company_name }}
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list>
                <div v-if="profile.sent_resume==1 && profile.dist_active==1 && profile.admin_accept==1">
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
                    v-if="profile.dist_active==2 ||(profile.sent_resume==1 && profile.admin_accept==0 && profile.dist_active==0 ) ">
                    <v-list-item to="/distProfileShow">
                        <v-list-item-icon>
                            <v-icon>mdi-pencil-box-outline</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title class="text-right" style="font-family:'Samim';">{{ title }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </div>
                <div v-if="profile.sent_resume==0">
                    <v-list-item to="/editDistributorProfile">
                        <v-list-item-icon>
                            <v-icon>mdi-pencil-box-outline</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title class="text-right" style="font-family:'Samim';">{{ title }}
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
        this.getProfile();
    },
    data: () => ({
        drawer: null,
        profile: {},
        title: '',
        items: [
            // { title: 'داشبورد', icon: 'mdi-view-dashboard', route:'/dashboard' },
            {title: 'پروفایل', icon: 'mdi-view-dashboard', route: '/distProfileShow'},
            {title: 'کتابهای طرح', icon: 'mdi-library', route: '/distributorBooks'},
            {title: 'فروشگاه های فعال', icon: 'mdi-folder-account', route: '/allShops'},
            {title: ' سفارش ها', icon: 'mdi-desktop-mac', route: '/allDistributorOrders'},
        ],
    }),

    methods: {
        logout() {
            axios.post('/logout')
                .then((response) => {
                    window.location.href = "login"
                })
        },
        getProfile() {
            axios.post('/distributor/getDistributorProfile')
                .then((data) => {
                    if (data.data) {
                        this.profile = data.data;
                        if (data.data.sent_resume)
                            this.title = 'مشاهده فرم ارسالی';
                        else
                            this.title = 'تکمیل ثبت نام';
                    }
                })
                .catch(() => {
                    alert('Problem');
                });
        }
    }

}
</script>
