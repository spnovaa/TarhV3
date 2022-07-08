<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <v-data-table v-if="showTable" :headers="headers" :items="books" :loading="loading" :search="search"
                      class="elevation-1" loading-text="درحال بارگذاری.... لطفا صبر کنید">
            <template v-slot:top>
                <v-toolbar aria-multiline="true" flat>
                    <v-toolbar-title>
                        <v-icon right>mdi-file-document</v-icon>
                        <span class="mr-2">
            <span class="hidden-sm-and-down">
              پیشخوان
            </span>
             فروشگاه
            {{shopName}}
          </span>

                    </v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>

                    <v-text-field v-model="search" append-icon="mdi-magnify" class="mr-2" hide-details label="جستجو"
                                  single-line></v-text-field>
                </v-toolbar>

            </template>

            <template v-slot:[`item.inventory`]="props">
                <h6>{{props.item.pivot.shop_lib+props.item.pivot.shop_inv}}</h6>
            </template>

            <template v-slot:[`item.actions`]="{ item }">
                <v-icon class="mr-2" small @click="editItem(item)">
                    mdi-shopping
                </v-icon>
            </template>
        </v-data-table>
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
        <v-card class="mt-n1"
                style="border-top-left-radius: 0; border-top-right-radius: 0; box-shadow: 0px 5px 1px -2px rgba(0, 0, 0, 0.2), 0px 5px 2px 0px rgba(0, 0, 0, 0.14), 0px 5px 5px 0px rgba(0, 0, 0, 0.12)">
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
                                        <v-text-field v-model.number="number" label="تعداد" type="number"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row
                                    v-if="orderActive && number>books[editedIndex].pivot.shop_lib+books[editedIndex].pivot.shop_inv">
                                    <div class="red--text">
                                        موجودی این کتاب در فروشگاه انتخاب شده تنها
                                        {{books[editedIndex].pivot.shop_lib+books[editedIndex].pivot.shop_inv}}
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
                            <v-btn
                                v-if="orderActive"
                                :disabled="number>books[editedIndex].pivot.shop_lib+books[editedIndex].pivot.shop_inv" color="blue darken-1" text
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
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-radio-group v-model="orderType">
                                <v-row>
                                    <v-radio label="
                      خرید
                  " value="1"></v-radio>
                                    &nbsp;&nbsp;&nbsp;
                                    <v-radio label="
                    مرجوع کردن
                  " value="2"></v-radio>
                                </v-row>

                            </v-radio-group>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="text-left ml-5">
                                <h5 style="display: inline-block;">مجموع سفارش:</h5> &nbsp;&nbsp;
                                <h2 style="display: inline-block;">{{ordersSumNormal}}</h2> &nbsp;&nbsp;
                                <h5 style="display: inline-block;">تومان</h5>
                            </div>
                        </v-col>

                    </v-row>
                    <v-divider inst></v-divider>
                    <div class="text-right">
                        <h6>درصورتی که موجودی فروشگاه در زمان بررسی سفارش، کمتر از درخواست شما باشد، امکان تایید نشدن
                            بخشی یا همه ی سفارش آن کتاب وجود دارد.</h6>
                        <h6 class="mt-3">هزینه ی حمل بار درصورت تعیین توسط فروشگاه، به رقم مذکور اضافه خواهد شد.</h6>
                        <h6 class="mt-3">اقلامی که خرید یا مرجوعی آن توسط فروشگاه مورد تایید قرار بگیرد پس از تایید وصول
                            توسط شما، در موجودی انبارتان اعمال میگردد</h6>
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
                        <v-btn v-if="showReturnOption" class="ma-3" color="success" dark to="../safirShowOrders">
                            مشاهده لیست سفارش ها
                        </v-btn>
                    </template>
                </div>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
    export default {
        data: () => ({
            id: '',
            shopName: '',
            orderActive: false,
            showReturnOption: false,
            orderType: "1",
            ordersSum: 0,
            orderSumNormal: '',
            singleOrderSum: 0,
            orders: [],
            number: '',
            loading: true,
            search: '',
            error: false,
            success: false,
            ErrMsg: '',
            showTable: false,
            dialog: false,
            dialogDelete: false,
            headers: [
                {text: 'نام کتاب', align: 'start', value: 'book_name'},
                {text: 'نام نویسنده', value: 'writer'},
                {text: 'انتشارات', value: 'publisher'},
                {text: ' قیمت به تومان', value: 'fee'},
                {text: 'شابک', value: 'barcode'},
                {text: 'موجودی فروشگاه', value: 'inventory'},
                {text: 'سفارش', value: 'actions', sortable: false},

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

            initialize() {
                axios.post('/getAllBooks', {"shop_id": this.id})
                    .then((data) => {
                        this.books = Object.values(data.data[0])
                        this.shopName = data.data[1]
                        console.log(this.books);
                        this.showTable = true
                        this.loading = false
                    })
                    .catch(() => {
                        alert('خطا در ارتباط با سرور')
                    })

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
                    this.books[this.editedIndex].number = this.number
                    this.books[this.editedIndex].singleOrderSum = this.books[this.editedIndex].number * this.books[this.editedIndex].fee
                    this.ordersSum = this.ordersSum + this.books[this.editedIndex].singleOrderSum
                    this.ordersSumNormal = this.ordersSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    this.orders.push(this.books[this.editedIndex])
                    this.ErrMsg = 'سفارش به لیست اضافه شد!'
                    this.success = true
                    this.number = ''
                    this.close()
                }

            },
            sendOrders() {
                this.showReturnOption = true
                const fd = new FormData()
                fd.append('orders', JSON.stringify(this.orders))
                fd.append('orderType', JSON.stringify(this.orderType))
                axios.post('/sendOrder', fd)
                    .then((data) => {
                        if (data.data == "SUCCESS") {
                            this.error = false
                            this.ErrMsg = 'سفارش با موفقیت ارسال شد'
                            this.success = true
                        } else {
                            this.ErrMsg = 'خطا در ارسال'
                            this.error = true
                        }
                    })
                    .catch(() => {
                        alert('دریافت اطلاعات با مشکل روبرو شد')
                    })
            },
            deleteRow(index) {
                this.ordersSum -= this.orders[index].singleOrderSum
                this.ordersSumNormal = this.ordersSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                this.orders.splice(index, 1);
            }
        },

    }
</script>
<style scoped>
    .v-input--radio-group--column .v-radio:not(:last-child):not(:only-child) {
        margin-bottom: 0px !important;
    }
</style>
