<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <v-data-table v-if="showTable" :headers="headers" :items="books" :loading="loading" :search="search"
                      class="elevation-1" loading-text="درحال بارگذاری.... لطفا صبر کنید">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <v-icon right>mdi-file-document</v-icon>
                        <span class="mr-2">
            کتابهای طرح
          </span>

                    </v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>

                    <v-text-field v-model="search" append-icon="mdi-magnify" class="mr-2" hide-details label="جستجو"
                                  single-line></v-text-field>

                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="headline">
                                عملیات حذف، غیرقابل بازگشت است. آیا اطمینان دارید؟
                            </v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">لغو</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">بله</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>

            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-icon class="mr-2" small @click="editItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon small @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                اطلاعاتی جهت نمایش موجود نیست
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
                style="border-top-left-radius: 0; border-top-right-radius: 0; box-shadow: 0px 5px 1px -2px rgba(0, 0, 0, 0.2), 0px 5px 2px 0px rgba(0, 0, 0, 0.14), 0px 5px 5px 0px rgba(0, 0, 0, 0.12);">
            <v-card-text align="right">
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn v-bind="attrs" v-on="on" class="mb-2" color="primary" dark @click="typeOne">
                            <v-icon dark right>mdi-plus</v-icon>
                            <span class="mr-1">
                کتاب جدید
              </span>
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.book_name" label="نام کتاب"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.writer" label="نویسنده"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.publisher" label="انتشارات"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.fee" label="قیمت"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field v-model="editedItem.barcode" :disabled="editedIndex > -1"
                                                      label="شابک"></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="close">
                                لغو
                            </v-btn>
                            <v-btn color="blue darken-1" text @click="save">
                                ذخیره
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <template>
                    <v-btn class="mb-2 mr-2" color="success" dark @click.prevent="updateBooks">
                        <v-icon dark right>mdi-content-save

                        </v-icon>
                        <span class="mr-2">
                ذخیره تغییرات
              </span>
                    </v-btn>
                </template>

            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
    export default {
        data: () => ({
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
                {text: 'ثبت کننده', value: 'editor'},
                {text: 'عملیات', value: 'actions', sortable: false},
            ],
            books: null,
            editedIndex: -1,
            editedItem: {
                book_name: '',
                writer: '',
                publisher: '',
                fee: '',
                barcode: '',
                editor: '',
                inventory: '',
                edited: '',
                editType: 0,
            },
            defaultItem: {
                book_name: '',
                writer: '',
                publisher: '',
                fee: '',
                editor: '',
                barcode: '',
                inventory: '',
                edited: '',
                editType: 0,
            },
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'کتاب جدید' : 'ویرایش اطلاعات'
            },
        },

        watch: {
            dialog(val) {
                val || this.close()
            },
            dialogDelete(val) {
                val || this.closeDelete()
            },
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                axios.post('/admin/getAllBooks')
                    .then((data) => {
                        this.books = data.data
                        this.showTable = true
                        this.loading = false
                    })
                    .catch(() => {
                        alert('خطا در ارتباط با سرور')
                    });
            },
            typeOne() {
                this.editType = 1
            },
            typeTwo() {
                this.editType = 2
            },
            editItem(item) {
                this.editedIndex = this.books.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem(item) {
                this.editedIndex = this.books.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            },

            deleteItemConfirm() {
                axios.post('/admin/deleteBook', this.editedItem)
                    .then((data) => {
                        console.log(data.data)
                    })
                    .catch(() => {
                        alert('حذف اطلاعات با مشکل روبرو شد');
                    });
                this.books.splice(this.editedIndex, 1)
                this.closeDelete()
            },

            close() {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
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
                if (this.editedIndex > -1) {
                    this.editedItem.editType = 2
                    this.editedItem.edited = 1
                    Object.assign(this.books[this.editedIndex], this.editedItem)
                    this.ErrMsg = 'برای نهایی شدن تغییرات بر روی دکمه ذخیره تغییرات کلیک کنید!'
                    this.success = true

                } else {
                    this.editedItem.edited = 1
                    this.editedItem.editType = 1
                    var barcodeErr = false;
                    var barcode = this.editedItem.barcode;
                    this.books.map(function (value, key) {
                        if (value.barcode == barcode) {
                            barcodeErr = true
                        }
                    })
                    if (!barcodeErr) {
                        this.editedItem.edited = 1
                        this.editedItem.edited = 2
                        this.ErrMsg = 'کتاب به لیست اضافه شد!'
                        this.success = true
                        this.books.push(this.editedItem)
                    } else {
                        this.ErrMsg = 'کتابی با این شابک موجود است!'
                        this.error = true
                    }

                }
                this.editType = 0
                this.close()
            },
            updateBooks() {
                const fd = new FormData();
                fd.append('books', JSON.stringify(this.books));
                axios.post('/admin/updateBooksList', fd)
                    .then((data) => {
                        if (data.data == "SUCCESS") {
                            this.error = false
                            this.ErrMsg = 'تغییرات با موفقیت در سرور ذخیره شد'
                            this.success = true
                        } else {
                            this.ErrMsg = 'اشکال در ذخیره سازی'
                            this.error = true
                        }
                    })
                    .catch(() => {
                        alert('دریافت اطلاعات با مشکل روبرو شد');
                    });
            }
        },
    }
</script>
