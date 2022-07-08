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
                    <span class="red--text">خرید</span>
                </v-card-title>
            </div>

            <v-card-text>
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
                                تعداد
                            </th>
                            <th class="text-right">
                                قیمت کل
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in order" :key="item.barcode"
                        >
                            <td class="text-right">{{ index+1 }}</td>
                            <td class="text-right">{{ item.book_name }}</td>
                            <td class="text-right">{{ item.barcode }}</td>
                            <td class="text-right">{{ item.fee }}</td>
                            <td class="text-right">{{ item.order_count }}</td>
                            <td class="text-right">{{ item.order_count*item.fee }}</td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <v-divider></v-divider>

                <v-row v-if="order">

                    <v-col cols="12" md="6">
                        <div class="text-left ">
                            <h5 style="display: inline-block;">مجموع سفارش تایید شده: </h5> &nbsp;&nbsp;
                            <h2 class="red--text" style="display: inline-block;">
                                {{ordersSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</h2> &nbsp;&nbsp;
                            <h5 style="display: inline-block;">تومان</h5>
                        </div>
                    </v-col>
                    <v-col cols="12" md="6">
                        <div class="text-left ml-5">
                            <h5 style="display: inline-block;"> تخفیف:</h5> &nbsp;&nbsp;
                            <h2 style="display: inline-block;">{{discount.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                ",")}}</h2> &nbsp;&nbsp;
                            <h5 style="display: inline-block;">تومان</h5>
                        </div>
                    </v-col>
                    <v-col cols="12" md="6">
                        <div class="text-left ml-5">
                            <h5 style="display: inline-block;"> پرداختی:</h5> &nbsp;&nbsp;
                            <h2 style="display: inline-block;">{{payment.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                ",")}}</h2> &nbsp;&nbsp;
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

                <v-btn class="ma-3" color="success" dark to="../safirShowOrders">
                    بازگشت به لیست
                </v-btn>

            </v-card-text>
        </v-card>
        <v-snackbar v-model="error" bottom color="red darken-2" top>
            <div align="center" justify="center">
                <v-icon right>mdi-comment-alert-outline</v-icon>
                <span class="ml-2">{{ErrMsg}}</span>
            </div>
        </v-snackbar>
        <v-snackbar v-model="success" bottom color="green darken-2" top>
            <div align="center" justify="center">
                <v-icon right> mdi-comment-check-outline</v-icon>
                <span class="ml-2">{{ErrMsg}}</span>
            </div>
        </v-snackbar>
    </v-container>
</template>

<script>
    export default {
        created() {
            this.id = this.$route.params.id;
            this.getOrder();
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
                form: {transition_number: ''}
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
                axios.post('/getCustomerOrder', {"transition_number": this.id})
                    .then((data) => {
                        if (data.data) {
                            this.order = data.data;
                            this.calcSum()
                        }
                    })
                    .catch(() => {
                        alert('دریافت اطلاعات با مشکل روبرو شد');
                    });
            },

        }

    }
</script>

<style scoped>
    .v-input--radio-group--column .v-radio:not(:last-child):not(:only-child) {
        margin-bottom: 0px !important;
    }
</style>
