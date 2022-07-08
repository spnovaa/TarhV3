<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <loading-component v-if="!loaded"></loading-component>

        <v-card v-if="loaded" class="px-5 boxborder">
            <div class="d-flex grow flex-wrap">
                <v-sheet class="success mt-n5 mb-3" style="border-radius:4px">
                    <v-icon class="ma-6"
                            dark style="font-size:2.5em"> mdi-cart-check
                    </v-icon>
                </v-sheet>
                <v-card-title>
                    جزئیات سفارش
                    &nbsp;
                    <span v-if="order!=null" class="red--text">{{ order[0].order_type == 1 ? 'خرید' : 'مرجوعی' }}</span>
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
                                درصد تخفیف
                            </th>
                            <th class="text-right">
                                مجموع پس ازتخفیف
                            </th>
                            <th class="text-right">
                                موجودی انبار
                            </th>
                            <th class="text-right" style="width:80px">
                                تعداد مورد تایید
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
                            <td class="text-right">{{ item.order_count }}</td>
                            <td class="text-right">{{ item.order_disc_percent }}</td>
                            <td class="text-right">{{ item.order_count * item.fee - item.order_discount }}</td>
                            <td class="text-right">{{ item.dist_inv }}</td>
                            <td class="text-right">
                                <v-text-field v-model.number="order[index].dist_accept" :disabled="!order[0].pending"
                                              dense style="width:80px" type="number"
                                              @input="calcSum"></v-text-field>
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
                        <v-text-field v-if="order" v-model.number="porterage" :disabled="!order[0].pending"
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
                                {{ ordersSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h2> &nbsp;&nbsp;
                            <h5 style="display: inline-block;">تومان</h5>
                        </div>
                    </v-col>
                </v-row>
                <div class="text-right">
                    <v-divider></v-divider>
                    <h6>
                        <v-icon style="color:#AEEA00">mdi-alert-rhombus-outline</v-icon>
                        تایید تعداد صفر به منزله ی عدم تایید سفارش آن کتاب خواهد بود.
                    </h6>
                    <h6 class="mt-3">
                        <v-icon style="color:#AEEA00">mdi-alert-rhombus-outline</v-icon>
                        اقلام خرید تایید شده توسط شما، پس از تایید وصول توسط کتابفروش، به انبار کتابفروشی اضافه خواهد
                        شد.
                    </h6>
                    <h6 class="mt-3">
                        <v-icon style="color:#AEEA00">mdi-alert-rhombus-outline</v-icon>
                        پس از تایید سفارش از سمت شما، اقلام تایید شده در موجودی شما اعمال می گردد. لذا
                        لطفا پیش از تایید سفارش از موجود بودن اقلام فوق، در بخش
                        <span class="red--text">کتاب های طرح</span>
                        اطمینان حاصل فرمایید. به روز نبودن موجودی از سمت شما باعث گمراهی کتابفروشان می شود.
                    </h6>

                </div>
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
                        <v-btn v-if="showReturnOption" class="ma-3" color="success" dark to="../allDistributorOrders">
                            بازگشت به لیست
                        </v-btn>
                    </template>
                </div>
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
            order: '',
            loaded: false

        }
    },

    methods: {
        calcSum() {
            this.ordersSum = 0
            for (const item of this.order) {
                if (item.dist_accept > 0) {
                    let price = item.fee * item.dist_accept * (100 - item.order_disc_percent) / 100
                    console.log(item.order_disc_percent)
                    let roundedPrice = Math.round((price + Number.EPSILON) * 100) / 100
                    this.ordersSum = this.ordersSum + roundedPrice
                }
            }
            this.ordersSum = this.ordersSum + this.porterage;
        },

        getOrder() {
            axios.post('/distributor/getOrder', {"transition_number": this.id})
                .then((data) => {
                    if (data.data) {
                        this.order = data.data;
                        this.porterage = data.data[0].porterage
                        this.porterage_type = data.data[0].porterage_type.toString()
                        this.calcSum()
                        this.loaded = true
                    }
                })
                .catch(() => {
                    alert('دریافت اطلاعات با مشکل روبرو شد');
                });
        },
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

                axios.post('/distributor/confirmOrders', fd)
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
                this.disabled = false
                this.error = true
            }
        },
        validateForm() {
            let isValid = true

            if (!this.chbox) {
                isValid = false
                this.ErrMsg = "لطفا تاییدیه فرم را علامت بزنید!"
                return isValid
            }
            if (this.order[0].porterage < 0) {
                isValid = false
                this.ErrMsg = "هزینه باربری نمیتواند منفی باشد!"
            }

            this.order.forEach(ord => {
                if (ord.dist_accept < 0) {
                    isValid = false
                    this.ErrMsg = "تعداد تایید شده نمیتواند منفی باشد!"
                }
            });
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
