<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <processing-component :processing="processing"></processing-component>

        <v-card class="pa-8 boxborder mt-5 mb-3">
            <div class="d-flex grow flex-wrap mr-n4">
                <v-sheet class="success mt-n13 mb-3" style="border-radius:4px">
                    <v-icon class="ma-6" dark style="font-size:2.5em">mdi-account-search</v-icon>
                </v-sheet>
                <v-card-title class="mt-n10">
                    مشخصات خریدار
                </v-card-title>
            </div>

            <v-card-text>
                <v-row>
                    <v-col cols="6" md="4">
                        <v-text-field v-model="national_id" :class="{err : idErr}" :disabled="inquired" dense
                                      label="کد ملی"
                                      outlined @keyup="validateID()"></v-text-field>
                    </v-col>
                    <v-col class="text-right" cols="6" md="4">
                        <v-btn v-if="!inquired && !disabledInquire" class="primary" @click.prevent="inquire">
                            <v-icon>mdi-database-search-outline</v-icon>
                            جستجوی کدملی
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row class="text-right">
                    <div v-if="disabledInquire" class="red--text">
                        <span><small>کد ملی نمیتواند بیش از 10 رقم داشته باشد.</small></span></div>
                </v-row>
                <v-row v-if="inquired">
                    <v-col cols="6" md="3">
                        <v-text-field v-model="customer.info.name" :disabled="isRegistered" dense label="نام"
                                      outlined></v-text-field>
                    </v-col>
                    <v-col cols="6" md="3">
                        <v-text-field v-model="customer.info.last_name" :disabled="isRegistered" dense label="نام خانوادگی"
                                      outlined></v-text-field>
                    </v-col>
                    <v-col cols="6" md="3">
                        <v-text-field v-model="customer.info.tel" :class="{err : telErr}"
                                      :disabled="isRegistered" :hint="telErr ? telCountErr : telHint"
                                      dense
                                      label="شماره موبایل" outlined
                                      @keyup="validateID()"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" md="3">
                        <v-text-field v-model="customer.info.used" dense disabled label="یارانه استفاده شده"
                                      outlined></v-text-field>
                    </v-col>
                </v-row>
                <v-row v-if="inquired && isSellCountLimited">
                    <div>
                        در این طرح
                        هر خریدار مجاز به خرید حداکثر
                        {{ customer.info.customer_buy_count_limit }}
                        جلد کتاب است. تعداد خریداری شده تاکنون:
                        <span class="red--text">
                            {{ customer.info.bought_count }}
                             جلد.
                        </span>
                    </div>
                </v-row>
            </v-card-text>
        </v-card>
        <div v-if="inquired">
            <v-data-table v-if="showTable" :headers="headers" :items="books" :items-per-page="3" :loading="loading"
                          :search="search" class="elevation-1" loading-text="درحال بارگذاری.... لطفا صبر کنید">
                <template v-slot:top>
                    <v-toolbar aria-multiline="true" flat>
                        <v-toolbar-title>
                            <v-icon right>mdi-file-document</v-icon>
                            <span class="mr-2">
              پیشخوان شما
            </span>

                        </v-toolbar-title>
                        <v-divider class="mx-4" inset vertical></v-divider>

                        <v-text-field v-model="search" append-icon="mdi-magnify" class="mr-2" hide-details label="جستجو"
                                      single-line></v-text-field>
                        <v-spacer></v-spacer>
                        <template>
                            <div class="text-center">
                                <v-dialog
                                    v-model="camActive"
                                    width="500"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            v-bind="attrs"
                                            v-on="on"
                                            color="red lighten-2"
                                            dark
                                            @click="camSwitch()"
                                        >
                                            بارکدخوان
                                        </v-btn>
                                    </template>

                                    <v-card>
                                        <v-card-title class="headline grey lighten-2">
                                            دوربین دستگاه را برروی شابک کتاب بگیرید
                                        </v-card-title>

                                        <v-card-text>
                                            <div v-if="camActive" id="camera" class="viewport">
                                                <video src=""></video>
                                                <canvas class="drawingBuffer"></canvas>
                                            </div>
                                        </v-card-text>

                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                color="primary"
                                                text
                                                @click="camSwitch()"
                                            >
                                                خروج
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </div>
                        </template>
                    </v-toolbar>

                </template>

                <template v-slot:[`item.safir_inv`]="props">
                    <h6 class="text-center">{{props.item.pivot.safir_inv}}</h6>
                </template>

                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon class="mr-2" small @click="editItem(item)">
                        mdi-shopping
                    </v-icon>
                </template>
            </v-data-table>
        </div>
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
        <v-card v-if="inquired" class="mt-n1"
                style="border-top-left-radius: 0; border-top-right-radius: 0; box-shadow: 0px 5px 1px -2px rgba(0, 0, 0, 0.2),
           0px 5px 2px 0px rgba(0, 0, 0, 0.14), 0px 5px 5px 0px rgba(0, 0, 0, 0.12)">
            <v-card-text align="right">
                <v-dialog v-model="dialog" max-width="500px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">افزودن به لیست سفارش</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.book_name" disabled
                                                      label="نام کتاب"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.writer" disabled
                                                      label="نویسنده"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.publisher" disabled
                                                      label="انتشارات"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.fee" disabled label="قیمت"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.barcode" disabled label="شابک"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model.number="number" :rules="countRules" label="تعداد"
                                                      type="number"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row v-if="orderActive && number>books[editedIndex].pivot.safir_inv">
                                    <div class="red--text">
                                        موجودی شما در این کتاب تنها
                                        {{books[editedIndex].pivot.safir_inv}}
                                        عدد است!
                                    </div>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="close">
                                لغو
                            </v-btn>
                            <v-btn v-if="orderActive" :disabled="(number>books[editedIndex].pivot.safir_inv) || number<0 "
                                   color="blue darken-1" text
                                   @click="save">
                                اضافه
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

            </v-card-text>
        </v-card>
        <v-card v-if="orders.length" class="pa-8 boxborder mt-10">
            <div class="d-flex grow flex-wrap mr-n4">
                <v-sheet class="success mt-n13 mb-3" style="border-radius:4px">
                    <v-icon class="ma-6" dark style="font-size:2.5em">mdi-shopping</v-icon>
                </v-sheet>
                <v-card-title class="mt-n10">
                    لیست سفارش
                </v-card-title>
            </div>
            <v-card-text>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                        <tr>
                            <th class="text-right">
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
                            <th class="text-right">
                                عملیات
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in orders" :key="item.barcode"
                        >
                            <td class="text-right">{{ item.book_name }}</td>
                            <td class="text-right">{{ item.barcode }}</td>
                            <td class="text-right">{{ item.fee }}</td>
                            <td class="text-right">{{ item.number }}</td>
                            <td class="text-right">{{ item.singleOrderSum }}</td>
                            <td class="text-right"><a role="button" style="cursor:pointer"><img
                                alt="del"
                                src="/images/delete.png"
                                style=" height:25px;"
                                @click="deleteRow(index)"></a>
                            </td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <v-divider></v-divider>
                <div v-if="orders.length">
                    <v-row class="d-flex flex-row-reverse">
                        <v-col cols="12" md="6">
                            <div class="text-left ml-5">
                                <h5 style="display: inline-block;">مجموع سفارش:</h5> &nbsp;&nbsp;
                                <h2 style="display: inline-block;">{{ordersSumNormal}}</h2> &nbsp;&nbsp;
                                <h5 style="display: inline-block;">تومان</h5>
                            </div>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="text-left ml-5">
                                <h5 style="display: inline-block;"> تخفیف:</h5> &nbsp;&nbsp;
                                <h2 style="display: inline-block;">{{discountNormal}}</h2> &nbsp;&nbsp;
                                <h5 style="display: inline-block;">تومان</h5>
                            </div>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="text-left ml-5">
                                <h5 style="display: inline-block;"> پرداختی:</h5> &nbsp;&nbsp;
                                <h2 style="display: inline-block;">{{paymentNormal}}</h2> &nbsp;&nbsp;
                                <h5 style="display: inline-block;">تومان</h5>
                            </div>
                        </v-col>
                    </v-row>
                    <v-divider inst></v-divider>
                    <div class="text-right">
                        <h6 class="mt-3">
                            در صورت ثبت موفقیت آمیز فاکتور، اقلام ثبت شده در موجودی انبار شما اعمال میگردند
                        </h6>
                        <h6 class="mt-3">
                            درصورتی که موجودی واقعی شما کمتر از موجودی انبار سایت است اطمینان حاصل کنید که وصول سفارشات
                            مربوط
                            به آن کتاب را در بخش سفارشات، اعلام کرده اید.
                        </h6>
                        <h6 class="mt-3">
                            پس از ثبت موفقیت آمیز فاکتور، پیامکی حاوی لیست اقلام خریداری شده برای مشتری ارسال میگردد.
                        </h6>
                    </div>
                    <template>
                        <v-btn v-if="!showReturnOption" class="mb-2 mr-2" color="primary" dark
                               @click.prevent="sendOrders">
                            <v-icon dark right>mdi-basket

                            </v-icon>
                            <span class="mr-2 mt-2">
                   تایید و ارسال سفارش
                </span>
                        </v-btn>
                        <v-btn v-if="showReturnOption" class="ma-3" color="success" dark @click="reload()">
                            فاکتور جدید
                        </v-btn>
                    </template>
                </div>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
    import Quagga from 'quagga';

    export default {
        data: () => ({
            camActive: false,
            customer: '',
            id: '',
            national_id: '',
            idErr: false,
            telErr: false,
            disabledInquire: false,
            isRegistered: -1,
            telCountErr: 'تلفن همراه 11 رقم است',
            telHint: '*********09',
            shopName: '',
            orderActive: false,
            showReturnOption: false,
            orderType: "1",
            ordersSum: 0,
            orderSumNormal: '',
            singleOrderSum: 0,
            orders: [],
            discount: '0',
            payment: '0',
            discount_raw: '0',
            discountNormal: '',
            paymentNormal: '',
            number: '',
            loading: true,
            search: '',
            error: false,
            success: false,
            ErrMsg: '',
            showTable: false,
            dialog: false,
            dialogDelete: false,
            inquired: false,
            isSellCountLimited: false,
            bought_count: 0,
            processing: false,
            headers: [
                {text: 'نام کتاب', align: 'start', value: 'book_name'},
                {text: 'نام نویسنده', value: 'writer'},
                {text: 'انتشارات', value: 'publisher'},
                {text: ' قیمت به تومان', value: 'fee'},
                {text: 'شابک', value: 'barcode'},
                {text: 'موجودی شما', value: 'safir_inv'},
                {text: 'سفارش', value: 'actions', sortable: false},

            ],
            countRules: [
                v => !!v || "الزامی",
                v => (v && v >= 0) || "تعداد باید بیشتر از صفر باشد",
            ],
            books: null,
            editedIndex: -1,
            editedItem: {
                book_name: '',
                writer: '',
                publisher: '',
                fee: '',
                editor: '',
                barcode: '',
                inventory: '',
                number: '',
                edited: '0',
            },
            defaultItem: {
                book_name: '',
                writer: '',
                publisher: '',
                fee: '',
                editor: '',
                barcode: '',
                inventory: '',
                number: '0',
                edited: '0',
            },
        }),

        watch: {
            dialog(val) {
                val || this.close()
            },
            dialogDelete(val) {
                val || this.closeDelete()
            },

        },

        created() {
            this.id = this.$route.params.id;
            this.initialize()
        },

        methods: {
            reload() {
                window.location.reload();
            },
            camSwitch() {
                this.camActive = this.camActive ? false : true
                if (this.camActive) {
                    setTimeout(() => {
                        Quagga.init({
                            inputStream: {
                                name: "Live",
                                type: "LiveStream",
                                target: document.querySelector('#camera')    // Or '#yourElement' (optional)
                            },
                            decoder: {
                                readers: ["code_128_reader"]
                            }
                        }, function (err) {
                            if (err) {
                                console.log(err);
                                return
                            }
                            console.log("Initialization finished. Ready to start")
                            Quagga.start()
                        });
                        var vm = this
                        Quagga.onDetected(function (data) {
                            console.log(data.codeResult.code)
                            vm.search = data.codeResult.code
                            vm.camActive = false
                            Quagga.stop()
                        })
                    }, 1000);
                }
                if (!this.camActive) {
                    Quagga.stop()
                }
            },

            initialize() {
                axios.post('/getInventory')
                    .then((data) => {
                        this.books = data.data
                        this.showTable = true
                        this.loading = false
                    })
                    .catch(() => {
                        alert('خطا در ارتباط با سرور')
                    });

            },


            editItem(item) {
                this.editedIndex = this.books.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
                this.orderActive = true
            },


            close() {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.orderActive = false
                    this.editedIndex = -1
                })
            },

            closeDelete() {
                this.dialogDelete = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            save() {
                if (!this.number || this.number == 0)
                    this.close()
                else {
                    for (const id in this.orders) {
                        if (this.books[this.editedIndex].barcode == this.orders[id].barcode) {
                            this.number = this.number + this.orders[id].number
                            this.orders.splice(id, 1);
                        }

                    }

                    this.books[this.editedIndex].number = this.number
                    this.books[this.editedIndex].singleOrderSum = this.books[this.editedIndex].number * this.books[this.editedIndex].fee


                    this.orders.push(this.books[this.editedIndex])
                    this.ordersSum = 0
                    this.discount_raw = 0
                    this.payment = 0
                    for (const id in this.orders) {
                        this.ordersSum = this.ordersSum + this.orders[id].fee * this.orders[id].number
                    }
                    this.discount_raw = this.ordersSum * this.customer.info.percentage_setting
                    this.discount = this.discount_raw + this.customer.info.used >= this.customer.info.limit_setting ?
                        (this.customer.info.limit_setting - this.customer.info.used) : this.discount_raw
                    this.payment = this.ordersSum - this.discount

                    this.ordersSumNormal = this.ordersSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    this.discountNormal = this.discount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    this.paymentNormal = this.payment.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    this.bought_count += this.number
                    this.ErrMsg = 'سفارش به لیست اضافه شد!'
                    this.success = true
                    this.number = ''
                    this.close()
                }

            },
            sendOrders() {
                let validated = true
                let isBuyCountValid =
                    (this.customer.info.customer_buy_count_limit == 0 ||
                        (this.bought_count + this.customer.info.bought_count) <= this.customer.info.customer_buy_count_limit)
                if (!this.customer.info.name || !this.customer.info.last_name || !this.customer.info.tel || !isBuyCountValid) {
                    validated = false
                } else this.processing = true;
                if (validated) {
                    this.sendDisabled = true
                    this.customer.info.bought_count += this.bought_count
                    axios.post('/sendInvoice', {"orders": this.orders, "customer": this.customer})
                        .then((data) => {
                            if (data.data == "SUCCESS") {
                                this.error = false
                                this.ErrMsg = 'سفارش با موفقیت ارسال شد'
                                this.showReturnOption = true
                                this.success = true
                            } else {
                                this.ErrMsg = 'خطا در ارسال'
                                this.error = true
                            }
                            this.processing = false;
                        })
                        .catch(() => {
                            alert('دریافت اطلاعات با مشکل روبرو شد')
                        })
                } else if (isBuyCountValid) {
                    this.error = true
                    this.ErrMsg = 'مشخصات مشتری را کامل وارد کنید'

                } else if (!isBuyCountValid) {
                    this.error = true
                    this.ErrMsg = "هر کدملی تنها مجاز به خرید " +
                        this.customer.info.customer_buy_count_limit +
                        " جلد کتاب است!"
                }

            },
            deleteRow(index) {
                this.orders.splice(index, 1);
                this.ordersSum = 0
                this.discount_raw = 0
                this.payment = 0
                this.bought_count = 0
                for (const id in this.orders) {
                    this.ordersSum = this.ordersSum + this.orders[id].fee * this.orders[id].number
                    this.bought_count += this.orders[id].number
                }

                this.discount_raw = this.ordersSum * this.customer.info.percentage_setting
                this.discount = this.discount_raw + this.customer.info.used >= this.customer.info.limit_setting ?
                    (this.customer.info.limit_setting - this.customer.info.used) : this.discount_raw
                this.payment = this.ordersSum - this.discount

                this.ordersSumNormal = this.ordersSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                this.discountNormal = this.discount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                this.paymentNormal = this.payment.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")

            },
            inquire() {
                this.processing = true;
                if (this.national_id.length == 10) {
                    axios.post('/inquire', {"national_id": this.national_id})
                        .then((data) => {
                            if (data.data == "INCORRECT") {
                                this.error = true
                                this.ErrMsg = 'کد ملی وارد شده صحیح نیست!'
                            } else {
                                this.customer = data.data
                                this.customer.info.national_id = this.national_id
                                this.isRegistered = data.data.info.is_registered
                                if (data.data.info.customer_buy_count_limit > 0) this.isSellCountLimited = true
                                this.inquired = true
                            }
                            this.processing = false
                        })
                        .catch(() => {
                            alert('دریافت اطلاعات با مشکل روبرو شد')
                        })
                } else {
                    this.error = true;
                    this.ErrMsg = 'لطفا کد ملی 10 رقمی را به درستی وارد کنید'
                    this.processing = false
                }
            },
            validateID() {
                this.national_id = this.national_id.replace(/[^0-9]/g, '')
                if (this.inquired) {
                    this.customer.info.tel = this.customer.info.tel.replace(/[^0-9]/g, '')
                }
                var theEvent = window.event;
                // Handle paste
                if (theEvent.type === 'paste') {
                    key = event.clipboardData.getData('text/plain');
                } else {
                    // Handle key press
                    var key = theEvent.keyCode || theEvent.which;
                    key = String.fromCharCode(key);
                }
                var regex = /[0-9]/;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault) theEvent.preventDefault();
                }

                if (this.national_id.length > 10) {
                    this.idErr = true;
                    this.disabledInquire = true;
                } else {
                    this.idErr = false;
                    this.disabledInquire = false;
                }
                if (this.inquired) {
                    if (this.customer.info.tel.length > 11) {
                        this.telErr = true;
                    } else {
                        this.telErr = false;
                    }
                }
            }
        },

    }
</script>
<style scoped>
    .err .v-input__control .v-input__slot fieldset {
        color: red !important;
    }

    .v-input--radio-group--column .v-radio:not(:last-child):not(:only-child) {
        margin-bottom: 0px !important;
    }

    #camera video, canvas {
        width: 100%;
        height: auto;
    }

    #camera video.drawingBuffer, canvas.drawingBuffer {
        display: none;
    }
</style>
