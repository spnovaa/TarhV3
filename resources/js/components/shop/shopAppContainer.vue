<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app class="cyan darken-4" dark
                             right src="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg">
            <v-list-item>
                <v-list-item-avatar style="background-color:white;">
                    <v-img v-if="profile.profile_image" :src="'./images/shops/'+profile.profile_image"></v-img>
                    <v-img v-else src='./images/welcome/profile.jpg'></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title style="text-align:right">{{ this.profile.name }} {{ this.profile.last_name }}
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
                    <v-list-item to="/shopProfileShow">
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
                    <v-list-item to="/editShopProfile">
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

<!--            <shop-sidebar-component></shop-sidebar-component>-->
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
            title: '',
            drawer: null,
            profile: {
                user_id: '',
                name: '',
                last_name: '',
                shopName: '',
                shop_surface: '',
                tel: '',
                shop_tel: '',
                admin_accept: null,
                active: '',
                national_id: '',
                profile_image: '',
                living_state: '',
                living_city: '',
                living_area: '',
                living_street: '',
                shop_zip: '',
                sent_flag: '',
                percentage: '',
                shabaID: '',
                credit_card: '',
                sent_report: '',
            },
            items: [
                // { title: 'داشبورد', icon: 'mdi-view-dashboard', route:'/dashboard' },
                {title: 'پروفایل', icon: 'mdi-view-dashboard', route: '/shopProfileShow'},
                {title: 'فاکتورها', icon: 'mdi-receipt', route: '/shopAllOrders'},
                {title: 'فروش مستقیم', icon: 'mdi-cart-arrow-up', route: '/shopDirectSell'},
                {title: 'آمار فروش', icon: 'mdi-poll', route: '/shopSellStatistics'},
                {title: 'انبار', icon: 'mdi-store', route: '/shopInventory'},
                {title: 'کتاب های طرح', icon: 'mdi-library', route: '/shopBooks'},
                {title: 'پیشخوان شرکت پخش', icon: 'mdi-basket', route: '/allDists'},
                {title: 'فایل ها', icon: 'mdi-file-link', route: '/files'},
            ],
        }),

        methods: {
            logout() {
                axios.post('/logout')
                    .then((response) => {
                        window.location.href = "home"
                    })
            },
            getProfile() {
                axios.post('/shop/getShopProfile')
                    .then((data) => {
                        if (data.data) {
                            this.profile.user_id = data.data.id;
                            this.profile.shopName = data.data.shop_name;
                            this.profile.name = data.data.name;
                            this.profile.last_name = data.data.last_name;
                            this.profile.admin_accept = data.data.admin_accept;
                            this.profile.active = data.data.active;
                            this.profile.national_id = data.data.national_id;
                            this.profile.tel = data.data.tel;
                            this.profile.profile_image = data.data.profile_image;
                            this.profile.living_state = data.data.living_state;
                            this.profile.living_city = data.data.living_city;
                            this.profile.living_area = data.data.living_area;
                            this.profile.living_street = data.data.living_street;
                            this.profile.sent_flag = data.data.sent_flag;
                            this.profile.percentage = data.data.percentage;
                            this.profile.shabaID = data.data.shabaID;
                            this.profile.sent_report = data.data.sent_report;
                            this.profile.active = data.data.active;

                            this.profile.credit_card = data.data.credit_card;
                            this.profile.shop_zip = data.data.shop_zip;
                            this.profile.shop_surface = data.data.shop_surface;
                            this.profile.shop_tel = data.data.shop_tel;

                            if (data.data.sent_flag)
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
<style>
.v-data-table > .v-data-table__wrapper > table > tbody > tr > th,
.v-data-table > .v-data-table__wrapper > table > thead > tr > th,
.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {
    font-size: 16px !important;
    color: #006064 !important;
}
</style>
