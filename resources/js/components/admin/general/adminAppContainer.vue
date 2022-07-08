<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app class="cyan darken-4" dark
                             right src="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg">
            <v-list-item>
                <v-list-item-avatar style="background-color:white;">
                    <v-img src="./images/khooshe.png"></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title style="text-align:right">مدیریت سامانه</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list>
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
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

    export default {

        data: () => ({
            drawer: null,
            items: [
                {title: 'داشبورد', icon: 'mdi-desktop-mac', route: '/settings'},
                {title: ' آمار', icon: 'mdi-finance', route: '/adminStats'},
                // { title: 'داشبورد', icon: 'mdi-view-dashboard', route:'/dashboard' },
                {title: ' سفیران', icon: 'mdi-folder-account', route: '/allResumes'},
                {title: ' فروشگاه ها', icon: 'mdi-folder-account', route: '/allShopResumes'},
                {title: 'شرکت های جدید', icon: 'mdi-file', route: '/newDistResumes'},
                {title: 'فاکتورها', icon: 'mdi-store-outline', route: '/allTransitions'},
                {title: 'کتابهای طرح', icon: 'mdi-bookshelf', route: '/books'},
            ],
        }),

        methods: {
            logout() {
                axios.post('/logout')
                    .then((response) => {
                        window.location.href = "admin"
                    })
            },
        }

    }
</script>
