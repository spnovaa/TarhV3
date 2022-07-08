<template>
    <v-container class="grey lighten-2 pa-1" fluid>
        <div v-if="profile.sent_flag==1 && profile.admin_accept==1">

            <v-card class=" mb-5" dark>
                <v-card-text style="text-align:right;">
                    <v-row>
                        <v-col cols="3" style=" text-align:center; margin:auto">
                            <v-icon style="font-size:10vw; color:#FFB300">mdi-alert</v-icon>
                        </v-col>
                        <v-col cols="1">
                            <v-divider vertical></v-divider>
                        </v-col>
                        <v-col cols="8">
                            <h6 style=" line-height:26pt">
                                <ul>
                                    <li>
                                        <v-icon style="color:red">mdi-alert-rhombus-outline</v-icon>
                                        توجه فرمایید که شما، تنها قادر به ثبت فروش کتابهایی هستید که در این قسمت موجودی
                                        داشته باشند.
                                    </li>
                                    <li>
                                        <v-icon style="color:red">mdi-alert-rhombus-outline</v-icon>
                                        در صورتی که وصول سفارش هایی که به فروشگاه ارسال کرده اید را تایید کنید، ارقام
                                        تایید
                                        شده به صورت خودکار در موجودی انبار شما اعمال می شوند.
                                    </li>

                                </ul>
                            </h6>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
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

                <template v-slot:[`item.safir_inv`]="props">
                    <h6 class="text-center">{{ props.item.pivot.safir_inv }}</h6>
                </template>
                <template v-slot:no-data>
                    اطلاعاتی جهت نمایش موجود نیست
                </template>
            </v-data-table>
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
            <v-card class="mt-n1"
                    style="border-top-left-radius: 0; border-top-right-radius: 0; box-shadow: 0px 5px 1px -2px rgba(0, 0, 0, 0.2), 0px 5px 2px 0px rgba(0, 0, 0, 0.14), 0px 5px 5px 0px rgba(0, 0, 0, 0.12);">
                <v-card-text align="right">

                </v-card-text>
            </v-card>
        </div>
        <div v-else>
            <v-card>
                <v-card-text class="text-center">
                    کاربر گرامی لطفا از منو سمت راست نسبت به تکمیل اطلاعات خود اقدام فرمایید!
                </v-card-text>
            </v-card>
        </div>

    </v-container>
</template>
<script>
export default {
    props: ['profile'],

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
            {text: 'موجودی شما', value: 'safir_inv'},

        ],
        books: null,
    }),

    created() {
        this.initialize()
    },

    methods: {
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

    },
}
</script>
