<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <shop-saf-ord-alert v-if="isLoaded"></shop-saf-ord-alert>

        <loading-component v-if="!isLoaded"></loading-component>

        <v-card v-if="isLoaded" class="px-5 boxborder">
            <div class="d-flex grow flex-wrap">
                <v-sheet class="success mt-n5 mb-3" style="border-radius:4px">
                    <v-icon class="ma-6"
                            dark style="font-size:2.5em"> mdi-cart-check
                    </v-icon>
                </v-sheet>
                <v-card-title>
                    جزئیات سفارش
                    &nbsp;
                    <span v-if="order!=null" class="red--text">{{order[0].order_type==1 ?'خرید':'مرجوعی'}}</span>
                </v-card-title>
            </div>

            <v-card-text>
                <v-simple-table v-if="order!=null">
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

                            <th v-if="order[0].pending" class="text-right amber darken-2 white--text"
                                style="width:80px">
                                موجودی فروشگاه
                            </th>

                            <th class="text-right" style="width:80px">
                                فروش از فروشگاه
                            </th>

                            <th v-if="order[0].pending" class="text-right amber darken-2 white--text"
                                style="width:80px">
                                موجودی طرح
                            </th>

                            <th class="text-right" style="width:80px">
                                فروش از طرح
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
                            <td v-if="order[0].pending" class="text-right purple darken-4 white--text">
                                {{shopRemainings[index][2]}}
                            </td>
                            <td class="text-right">
                                <v-text-field v-model.number="order[index].inv_accept" :disabled="!order[0].pending"
                                              :rules="getTarhRemainingRule(index)" dense style="width:80px"
                                              type="number" @input="calcSum">
                                </v-text-field>
                            </td>
                            <td v-if="order[0].pending" class="text-right purple darken-4 white--text">
                                {{shopRemainings[index][1]}}
                            </td>
                            <td class="text-right">
                                <v-text-field v-model.number="order[index].tarh_accept" :disabled="!order[0].pending"
                                              :rules="getShopRemainingRule(index)" dense style="width:80px"
                                              type="number" @input="calcSum">
                                </v-text-field>
                            </td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>

                <v-divider></v-divider>

                <v-row>
                    <v-col cols="12" md="6">
                        <v-radio-group v-model="porterage_type" :disabled="!order[0].pending">
                            <v-row>
                                <h5>پرداخت هزینه باربری در:</h5>&nbsp;&nbsp;&nbsp;
                                <v-radio label="
                                       مقصد

                                " value="1"></v-radio>
                                &nbsp;&nbsp;&nbsp;
                                <v-radio label="
                                     مبدأ
                                " value="2"></v-radio>
                            </v-row>
                        </v-radio-group>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-if="order!=null" v-model.number="porterage" :disabled="!order[0].pending"
                                      label="هزینه باربری به تومان" type="number"
                                      @input="calcSum"></v-text-field>
                    </v-col>
                </v-row>

                <v-row v-if="order!=null">
                    <v-col v-if="order[0].pending" cols="12" md="6">
                        <v-checkbox v-model="chbox"
                                    label="موجودی سایت به روز است و امکان تامین یا دریافت اقلام فوق وجود دارد."></v-checkbox>
                    </v-col>
                    <v-col cols="12" md="6">
                        <div class="text-left ">
                            <h5 style="display: inline-block;">مجموع سفارش تایید شده: </h5> &nbsp;&nbsp;
                            <h2 class="red--text" style="display: inline-block;">
                                {{ordersSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</h2> &nbsp;&nbsp;
                            <h5 style="display: inline-block;">تومان</h5>
                        </div>
                    </v-col>
                </v-row>

                <shop-saf-ord-footer></shop-saf-ord-footer>

                <div v-if="order!=null">
                    <template v-if="order[0].pending">
                        <v-btn v-if="!showReturnOption" :disabled="disabled" class="ma-3" color="primary"
                               dark @click.prevent="confirm">
                            <v-icon right>mdi-content-save

                            </v-icon>
                            <span class="mr-2">
                            ارسال نتیجه سفارش
                        </span>
                        </v-btn>
                        <v-btn v-if="showReturnOption" class="ma-3" color="success" dark to="../shopAllOrders">
                            بازگشت به لیست
                        </v-btn>
                    </template>
                </div>
            </v-card-text>
        </v-card>


        <!-- ERROR ALERTS SNACKBAR -->
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
                porterage_type: '1',
                disabled: false,
                chbox: false,
                id: '',
                porterage: '0',
                result: '',
                ordersSum: '0',
                showReturnOption: false,
                success: false,
                ErrMsg: '',
                error: false,
                order: null,
                books: null,
                shopRemainings: [],
                isLoaded: false,
            }
        },

        methods: {
            calcSum() {
                this.ordersSum = 0
                for (const item of this.order) {

                    this.ordersSum = this.ordersSum + item.fee * item.inv_accept + item.fee * item.tarh_accept
                }
                this.ordersSum = this.ordersSum + this.porterage;
            },
            getShopRemainingRule(index) {
                return [
                    v => (v || '') <= this.shopRemainings[index][1] || this.maxExeeded()
                ]
            },
            getTarhRemainingRule(index) {
                return [
                    v => (v || '') <= this.shopRemainings[index][2] || this.maxExeeded()
                ]
            },

            maxExeeded() {
                return "بیش از موجودی!"
            },

            getOrder() {
                axios.post('/shop/getSafirOrder', {"transition_number": this.id})
                    .then((data) => {
                        if (data.data) {
                            this.order = data.data;
                            // this.porterage=order[0].porterage
                            this.porterage = data.data[0].porterage
                            this.porterage_type = data.data[0].porterage_type.toString()
                            this.calcSum()
                            this.getRemainings()

                        }
                    })
                    .catch(() => {
                        alert('دریافت اطلاعات با مشکل روبرو شد');
                    });
            },
            getRemainings() {
                axios.post('/shop/getInventory')
                    .then((data) => {
                        this.books = Object.values(data.data)

                        this.books.forEach(book => {
                            this.order.forEach(ord => {
                                if (book["barcode"] == ord["barcode"]) {
                                    let barcode = book["barcode"]
                                    let tarhCount = book.pivot["shop_inv"]
                                    let shopCount = book.pivot["shop_lib"]
                                    this.shopRemainings.push([barcode, tarhCount, shopCount])
                                }
                            });
                        });
                        this.isLoaded = true
                    })
                    .catch(() => {
                        alert('خطا در ارتباط با سرور')
                    });
            }

            ,
            confirm() {
                if (this.chbox)
                    this.disabled = true
                var porterage = this.porterage;
                var porterage_type = this.porterage_type;
                this.order.map(function (value, key) {
                    value.porterage = porterage
                    value.porterage_type = porterage_type
                })
                if (this.validateForm()) {
                    const fd = new FormData()
                    fd.append('order', JSON.stringify(this.order))

                    axios.post('/shop/confirmSafirOrders', fd)
                        .then((data) => {
                            if (data.data == "SUCCESS") {
                                this.error = false
                                this.ErrMsg = 'سفارش با موفقیت ارسال شد'
                                this.success = true
                                this.showReturnOption = true;
                            } else {
                                this.ErrMsg = 'خطا در ارسال'
                                this.error = true
                            }
                        })
                        .catch(() => {
                            alert('دریافت اطلاعات با مشکل روبرو شد')
                        })
                } else {
                    this.error = true
                    this.disabled = false
                }
            },

            validateForm() {
                let isValid = true
                let index = 0
                this.order.forEach(ord => {
                    let inv_accept = ord.inv_accept
                    let inv_remaining = this.shopRemainings[index][2]
                    let tarh_accept = ord.tarh_accept
                    let tarh_inv = this.shopRemainings[index][1]

                    if (inv_accept > inv_remaining || tarh_accept > tarh_inv) {
                        this.ErrMsg = "ارقام تایید شده از موجودی بیشتر است!"
                        isValid = false
                    }

                    if (inv_accept + tarh_accept > ord.order_count) {
                        isValid = false
                        this.ErrMsg = "مجموع تعداد جلد تایید شده نباید از تعداد سفارش سفیر بیشتر باشد!"
                    }

                    if (inv_accept < 0 || tarh_accept < 0) {
                        isValid = false
                        this.ErrMsg = "تعداد تایید شده نمیتواند منفی باشد!"
                    }

                    index++
                });
                if (!this.chbox) {
                    isValid = false
                    this.ErrMsg = "لطفا تاییدیه فرم را علامت بزنید!"
                }
                return isValid
            }
        }

    }
</script>
<style scoped>
    .v-input--radio-group--column .v-radio:not(:last-child):not(:only-child) {
        margin-bottom: 0px !important;
    }
</style>
