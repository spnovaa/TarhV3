<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <v-card class=" mb-10 mt-2 m-0 mr-0 boxborder" style="height: 100vh">
            <v-card-title dark style="background-color: #EEEEEE">
                <v-icon class="ma-3"> mdi-chart-areaspline</v-icon>
                آمار
            </v-card-title>
            <v-card-text class="text-right">
                <v-card class="col-12 col-md-4 mt-4 pa-0" style="background-color: #FAFAFA">
                    <v-img class="white--text align-end"
                           height="150px"
                           src="/images/ui/backgrounds/card-gold1.jpg">
                        <v-card-title>
                            <span style="font-size: medium;font-weight: bold; color: #2b0000;">
                            مجموع فروش فروشگاه ها
                            </span>
                        </v-card-title>
                        <v-card-text class="text-center mt-3 mb-9">
                            <span style="font-size: x-large;font-weight: bold; text-decoration: underline">{{
                                    shopsTotalSell
                                }}</span>
                            <span style="font-size: large">
                                جلد
                            </span>
                        </v-card-text>
                    </v-img>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn icon style="color: #4CAF50" @click="getShopsBooksSellStats()">
                            <v-icon>mdi-file-excel</v-icon>
                        </v-btn>
                        <div> فروشگاه-کتاب</div>

                        <v-spacer></v-spacer>

                        <v-btn icon style="color: #00BFA5" @click="getShopsTotalSellStats()">
                            <v-icon>mdi-file-excel</v-icon>
                        </v-btn>
                        <div> فروشگاه</div>
                        <v-spacer></v-spacer>

                    </v-card-actions>
                </v-card>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: "stats",
    data: () => ({
        shopsTotalSell: '',
    }),
    methods: {
        getShopTotalSell() {
            axios.post('/admin/getShopTotalSell')
                .then((data) => {
                    this.shopsTotalSell = data.data
                })
                .catch(() => {
                    alert('خطا در ارتباط با سرور')
                });
        },
        getShopsBooksSellStats() {
            window.open('/admin/getShopsBooksSellStats');
        },
        getShopsTotalSellStats() {
            window.open('/admin/getShopsTotalSellStats');
        }
    },
    created() {
        this.getShopTotalSell();
    },
}
</script>

<style scoped>

</style>
