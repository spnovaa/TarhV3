<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <shop-inv-alert></shop-inv-alert>

        <v-data-table v-if="showTable" :headers="headers" :items="books" :loading="loading" :search="search"
                      class="elevation-1" loading-text="درحال بارگذاری.... لطفا صبر کنید">
            <template v-slot:top>
                <v-toolbar aria-multiline="true" flat>
                    <v-toolbar-title>
                        <v-icon right>mdi-file-document</v-icon>
                        <span class="mr-2">
             انبار شما
          </span>

                    </v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>

                    <v-text-field v-model="search" append-icon="mdi-magnify" class="mr-2" hide-details label="جستجو"
                                  single-line></v-text-field>
                </v-toolbar>

            </template>
            <template v-slot:[`item.shop_lib`]="props">
                <v-text-field
                    v-model.number="props.item.pivot.shop_lib"
                    dense
                    name="quantity"
                    type="number"
                ></v-text-field>
            </template>
            <template v-slot:[`item.shop_inv`]="props">
                <h6 class="text-center">{{props.item.pivot.shop_inv}}</h6>
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
    import invoice from '../safir/invoice.vue';

    export default {
        components: {invoice},
        data: () => ({
            loading: true,
            search: '',
            error: false,
            success: false,
            ErrMsg: '',
            showTable: '',
            headers: [
                {text: 'نام کتاب', align: 'start', value: 'book_name'},
                {text: 'نام نویسنده', value: 'writer'},
                {text: 'انتشارات', value: 'publisher'},
                {text: ' قیمت به تومان', value: 'fee'},
                {text: 'شابک', value: 'barcode'},
                {text: 'موجودی سامانه', value: 'shop_inv'},
                {text: 'موجودی فروشگاه', value: 'shop_lib'},
            ],
            books: null,
        }),

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                axios.post('/shop/getInventory')
                    .then((data) => {
                        this.books = Object.values(data.data)
                        this.showTable = true
                        this.loading = false
                    })
                    .catch(() => {
                        alert('خطا در ارتباط با سرور')
                    });

            },

            save() {
                if (this.editedIndex > -1) {
                    this.editedItem.edited = 1

                    Object.assign(this.books[this.editedIndex], this.editedItem)
                    this.ErrMsg = 'برای نهایی شدن تغییرات بر روی دکمه ذخیره تغییرات کلیک کنید!'
                    this.success = true
                }

            },
            updateBooks() {
                const fd = new FormData();
                fd.append('books', JSON.stringify(this.books))
                axios.post('/shop/updateInventory', fd)
                    .then((data) => {
                        if (data.data == "SUCCESS") {
                            this.error = false
                            this.ErrMsg = 'انبار با موفقیت به روز رسانی شد'
                            this.success = true
                        } else {
                            this.ErrMsg = 'اشکال در ذخیره سازی'
                            this.error = true
                        }
                    })
                    .catch(() => {
                        alert('دریافت اطلاعات با مشکل روبرو شد')
                    });
            }
        },
    }
</script>
