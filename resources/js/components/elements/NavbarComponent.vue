<template>
    <v-app>
        <nav style="direction:rtl font-family:'Samim'">
            <v-app-bar app dark fixed src="https://ak.picdn.net/shutterstock/videos/33743356/thumb/8.jpg">
                <v-app-bar-nav-icon dark @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
                <v-toolbar-title>
                <span class="font-weight-light">
                    سامانه خوشه
                </span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn color="black" dark small>
                    <v-icon>mdi-exit-to-app</v-icon>
                    <span>خروج</span>
                </v-btn>
            </v-app-bar>

        </nav>
        <v-sheet class="overflow-hidden" height="100%" style="position: relative;">

            <v-navigation-drawer v-model="drawer" absolute class="blue-grey darken-2" dark right temporary>
                <v-list-item>
                    <v-list-item-avatar>
                        <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>مصطفی رحمتی</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>

                <v-list dense>
                    <v-list-item v-for="item in items" :key="item.title" :to="item.route" router>
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>
        </v-sheet>
    </v-app>

</template>

<script>
    export default {
        data: () => ({
            drawer: null,
            items: [
                {title: 'Home', icon: 'mdi-view-dashboard'},
                {title: 'About', icon: 'mdi-forum'},
            ],
        })
    }
</script>
