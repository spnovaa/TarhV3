<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <v-card class="px-5 boxborder mt-5">
            <div class="d-flex grow flex-wrap">
                <v-sheet class="success mt-n5 mb-3" style="border-radius:4px">
                    <v-icon class="ma-6"
                            dark style="font-size:2.5em"> mdi-cart-check
                    </v-icon>
                </v-sheet>
                <v-card-title>
                    جزئیات سفارش
                    &nbsp;
                    <span class="red--text">فروش مستقیم</span>
                </v-card-title>
                <v-spacer></v-spacer>
                <div class="ma-5">
                    <h6>
                        زمان ثبت:
                        &nbsp;&nbsp;&nbsp;
                        <span style="font-weight: normal">
                            {{ factorDate }}
                        </span>
                    </h6>
                </div>
            </div>

            <v-card-text>
                <v-divider class="mt-0 mb-0" style="border-color: #4BB543!important"></v-divider>
                <v-row v-if="order" class="text-right">
                    <v-col cols="12">
                        <h5>
                            مشخصات خریدار
                        </h5>
                    </v-col>
                    <v-col cols="4">
                        <span style="font-weight:bold">
                            نام:
                        </span>
                        <span>
                            {{ customer.name }}
                            {{ customer.last_name }}
                        </span>
                    </v-col>
                    <v-col cols="4">
                        <span style="font-weight:bold">
                            تلفن همراه:
                        </span>
                        <span>
                            {{ customer.tel }}
                        </span>
                    </v-col>
                    <v-col cols="4">
                        <span style="font-weight:bold">
                            کد ملی:
                        </span>
                        <span>
                            {{ customer.national_id }}
                        </span>
                    </v-col>
                </v-row>
                <v-divider class="mt-0 mb-0" style="border-color: #4BB543!important"></v-divider>
                <v-row v-if="order" class="text-right mt-0">
                    <v-col class="mt-0" cols="12">
                        <h5 class="mt-0">
                            مشخصات فروشنده
                        </h5>
                    </v-col>
                    <v-col cols="4">
                        <span style="font-weight:bold">
                            فروشگاه:
                        </span>
                        <span>
                            {{ seller.shop_name }}
                        </span>
                    </v-col>
                    <v-col cols="4">
                        <span style="font-weight:bold">
                            تلفن:
                        </span>
                        <span>
                            {{ seller.shop_tel }}
                        </span>
                    </v-col>
                    <v-col cols="4">
                        <span style="font-weight:bold">
                            نام مسئول :
                        </span>
                        <span>
                            {{ seller.name }}
                            {{ seller.last_name }}
                        </span>
                    </v-col>
                </v-row>
                <v-divider class="mt-0 mb-5" style="border-color: #4BB543!important"></v-divider>

                <v-simple-table v-if="order">
                    <template v-slot:default>
                        <thead>
                        <tr>
                            <th class="text-right">
                                ردیف
                            </th>
                            <th class="text-right" style="min-width:150px">
                                نام کتاب
                            </th>
                            <th class="text-right">
                                شابک
                            </th>
                            <th class="text-right">
                                فی
                            </th>
                            <th class="text-right">
                                سامانه
                            </th>
                            <th class="text-right">
                                فروشگاه
                            </th>
                            <th class="text-right">
                                قیمت کل
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in order" :key="item.barcode"
                        >
                            <td class="text-right">{{ index + 1 }}</td>
                            <td class="text-right">{{ item.book_name }}</td>
                            <td class="text-right">{{ item.barcode }}</td>
                            <td class="text-right">{{ item.fee }}</td>
                            <td class="text-right">{{ item.shop_inv }}</td>
                            <td class="text-right">{{ item.shop_lib }}</td>
                            <td class="text-right">{{ item.order_count * item.fee }}</td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <v-divider></v-divider>

                <v-row v-if="order">
                    <v-col cols="12" md="6">
                        <div class="text-left ml-5">
                            <h5 style="display: inline-block;"> تخفیف:</h5> &nbsp;&nbsp;
                            <h2 style="display: inline-block;">{{
                                    discount.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                        ",")
                                }}</h2> &nbsp;&nbsp;
                            <h5 style="display: inline-block;">تومان</h5>
                        </div>
                    </v-col>
                    <v-col cols="12" md="6">
                        <div class="text-left ">
                            <h5 style="display: inline-block;">مجموع سفارش: </h5> &nbsp;&nbsp;
                            <h2 class="red--text" style="display: inline-block;">
                                {{ ordersSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h2> &nbsp;&nbsp;
                            <h5 style="display: inline-block;">تومان</h5>
                        </div>
                    </v-col>

                    <v-col cols="12" md="6">
                        <div class="text-left ml-5">
                            <h5 style="display: inline-block;"> پرداختی:</h5> &nbsp;&nbsp;
                            <h2 style="display: inline-block;">{{
                                    payment.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                        ",")
                                }}</h2> &nbsp;&nbsp;
                            <h5 style="display: inline-block;">تومان</h5>
                        </div>
                    </v-col>
                </v-row>
                <div class="text-right">
                    <v-divider></v-divider>
                    <h6 class="mt-3">
                        پس از ثبت موفقیت آمیز فاکتور، پیامکی حاوی لیست اقلام خریداری شده برای مشتری ارسال میگردد.
                    </h6>
                </div>

                <v-btn class="ma-3" color="success" dark to="../shopAllOrders">
                    بازگشت به لیست
                </v-btn>

            </v-card-text>
        </v-card>
        <v-snackbar v-model="error" bottom color="red darken-2" top>
            <div align="center" justify="center">
                <v-icon right>mdi-comment-alert-outline</v-icon>
                <span class="ml-2">{{ ErrMsg }}</span>
            </div>
        </v-snackbar>
        <v-snackbar v-model="success" bottom color="green darken-2" top>
            <div align="center" justify="center">
                <v-icon right> mdi-comment-check-outline</v-icon>
                <span class="ml-2">{{ ErrMsg }}</span>
            </div>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    created() {
        this.id = this.$route.params.id;
        this.getOrder();
        this.getCustomerAndSeller();
    },
    data() {
        return {
            disabled: false,
            id: '',
            result: '',
            ordersSum: '0',
            payment: '0',
            discount: '0',
            success: false,
            ErrMsg: '',
            error: false,
            order: '',
            form: {transition_number: ''},
            customer: [],
            seller: [],
            factorDate: '',
            mainDate: ''
        }
    },

    methods: {
        calcSum() {
            this.ordersSum = 0
            for (const item of this.order) {
                this.ordersSum = this.ordersSum + item.fee * item.order_count
            }
            this.discount = this.order[0].order_discount
            this.payment = this.ordersSum - this.discount
        },

        getOrder() {
            axios.post('/shop/getCustomerOrder', {"transition_number": this.id})
                .then((data) => {
                    if (data.data) {
                        this.order = data.data;

                        this.mainDate = this.order[0].created_at;
                        let year = parseInt(this.mainDate.substring(0, 4))
                        let month = parseInt(this.mainDate.substring(5, 7)) - 1
                        let day = parseInt(this.mainDate.substring(8, 10))
                        this.factorDate = new JDate(new Date(year, month, day)).format('dddd DD MMMM YYYY');

                        this.calcSum()
                    }
                })
                .catch(() => {
                    alert('دریافت اطلاعات با مشکل روبرو شد');
                });
        },
        getCustomerAndSeller() {
            axios.post('/shop/getCustomerAndSeller', {"transition_number": this.id})
                .then((data) => {
                    if (data.data) {
                        this.customer = data.data.customer
                        this.seller = data.data.seller
                    }
                })
                .catch(() => {
                    alert('دریافت اطلاعات با مشکل روبرو شد');
                });
        }

    }

}
</script>

<style scoped>
.v-input--radio-group--column .v-radio:not(:last-child):not(:only-child) {
    margin-bottom: 0px !important;
}
</style>
