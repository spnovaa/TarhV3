<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <v-card class="pa-8 boxborder mt-5">
            <div class="d-flex grow flex-wrap mr-n4">
                <v-sheet class="success mt-n13 mb-3" style="border-radius:4px">
                    <v-icon class="ma-6" dark style="font-size:2.5em">mdi-shopping</v-icon>
                </v-sheet>
                <v-card-title class="mt-n10">
                    آمار تجمیعی فروش مستقیم
                </v-card-title>
            </div>
            <v-card-text class="text-right">
                <v-data-table v-if="showTable" :headers="headers" :items="books" :search="search" class="elevation-1 ">
                    <template v-slot:top>
                        <v-toolbar aria-multiline="true" flat>
                            <v-toolbar-title>
                                <v-icon right>mdi-file-document</v-icon>
                                <span class="mr-2">
                                    فروش مستقیم
                                </span>

                            </v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-text-field v-model="search" append-icon="mdi-magnify" class="mr-2" hide-details
                                          label="جستجو"
                                          single-line></v-text-field>
                            <v-btn class="mx-3" color="#33691E" dark @click="getShopDirectSellStatsExcel">
                                <v-icon>mdi-microsoft-excel</v-icon>
                            </v-btn>
                        </v-toolbar>

                    </template>
                    <template v-slot:no-data>
                        اطلاعاتی جهت نمایش موجود نیست
                    </template>
                </v-data-table>

                <v-card class="mt-10 " color="#FFFF8D">
                    <v-card-text>
                        <v-row class="justify-center">
                            <div>
                                <h5>
                                    مجموع دریافتی از مشتری:
                                    <span style="color: green">{{totalGain}}</span>
                                    تومان
                                </h5>
                            </div>
                        </v-row>

                    </v-card-text>
                </v-card>
                <div class="text-right">
                    <v-divider></v-divider>
                    <h6 class="mt-3">
                        رقم دریافتی شما با کسر تخفیف اعمال شده از رقم پشت جلد، محاسبه شده است.
                    </h6>
                </div>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: "shopSellStats",
    data: () => ({
        loading: true,
        search: '',
        showTable: false,
        books: [],
        headers: [
            {text: 'نام کتاب', align: 'start', value: 'book_name'},
            {text: 'انتشارات', value: 'publisher'},
            {text: 'شابک', value: 'barcode'},
            {text: 'فی', value: 'fee'},
            {text: 'تعداد فروش', value: 'sellCount'},
            {text: 'دریافتی از مشتری', value: 'sellAmount'},
        ],
        totalGain: 0
    }),
    created() {
        this.getShopDirectSellStats()
    },
    methods: {
        getShopDirectSellStats() {
            axios.post('/shop/getShopDirectSellStats')
                .then((data) => {
                    this.books = data.data
                    this.showTable = true
                    this.loading = false
                    this.calcTotalGain()
                })
                .catch(() => {
                    alert('خطا در ارتباط با سرور')
                });
        },
        getShopDirectSellStatsExcel() {
            window.open("/shop/getShopDirectSellStatsExcel")
        },

        calcTotalGain() {
            this.books.forEach(element => {
                this.totalGain += element.sellAmount
                element.sellAmount = this.numberWithCommas(element.sellAmount)
                element.fee = this.numberWithCommas(element.fee)
            });
            this.totalGain = this.numberWithCommas(this.totalGain)
        },

        numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    }
}
</script>

<style scoped>

</style>
