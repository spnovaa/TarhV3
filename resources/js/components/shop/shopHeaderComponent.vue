<template>
    <v-app style="font-family:Samim">
        <div>
            <v-toolbar
                circle
                dark
                src="https://ak.picdn.net/shutterstock/videos/33743356/thumb/8.jpg"
            >
                <a href="https://tarh.khooshe.org/">
                    <v-btn icon>
                        <v-icon> mdi-home-account</v-icon>
                    </v-btn>
                </a>

                <v-toolbar-title>ورود فروشگاه</v-toolbar-title>
                <v-spacer></v-spacer>
                <shop-register-component></shop-register-component>
            </v-toolbar>
        </div>
    </v-app>
</template>
<script>

    export default {
        name: 'App',
    }
</script>
