<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>
        <v-card class="pa-8 boxborder mt-5">
            <div class="d-flex grow flex-wrap mr-n4">
                <v-sheet class="success mt-n13 mb-3" style="border-radius:4px">
                    <v-icon class="ma-6" dark style="font-size:2.5em">mdi-shopping</v-icon>
                </v-sheet>
                <v-card-title class="mt-n10">
                    سفارش های واصله و ارسالی
                </v-card-title>
            </div>
            <v-card-text class="text-right">
                <h6>
                    در این بخش میتوانید فروش مستقیم یا سفارش هایی که برای شرکت پخش ارسال کرده اید
<!--                    یا از سمت سفیران-->
<!--                    دریافت کرده اید -->
                    را مشاهده کنید.
                </h6>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="12">
                        <v-radio-group v-model="tableType">
                            <v-row>
                                <v-divider class="mx-4" inset vertical></v-divider>
                                <v-radio label="
                      سفارشهای ارسالی به شرکت پخش
                      " value="1"></v-radio>
                                &nbsp;&nbsp;&nbsp;
<!--                                <v-divider class="mx-4" inset vertical></v-divider>-->
<!--                                <v-radio label="-->
<!--                       سفارش های دریافتی از سفیران-->
<!--                      " value="2"></v-radio>-->
                                &nbsp;&nbsp;&nbsp;
                                <v-divider class="mx-4" inset vertical></v-divider>
                                <v-radio label="
                      فروش مستقیم
                      " value="3"></v-radio>
                            </v-row>
                        </v-radio-group>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>


        <v-card v-if="tableType==1" class="mt-3">
            <v-card-title>
                <v-text-field v-model="search" append-icon="mdi-magnify" hide-details label="Search"
                              single-line></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="orders" :search="search" :sort-desc="true"
                          sort-by="transition_number">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn :to="{ path: '/shopOrderShow/'+ item.transition_number}" color="primary" dark fab
                           title="مشاهده"
                           x-small>
                        <v-icon small>mdi-eye</v-icon>
                    </v-btn>

                </template>
            </v-data-table>
        </v-card>
        <v-card v-if="tableType==2" class="mt-3">
            <v-card-title>
                <v-text-field v-model="search" append-icon="mdi-magnify" hide-details label="Search"
                              single-line></v-text-field>
            </v-card-title>
            <v-data-table :headers="safirHeaders" :items="safirOrders" :search="search" :sort-desc="true"
                          sort-by="transition_number">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn :to="{ path: '/safirOrderShow/'+ item.transition_number}" color="primary" dark fab
                           title="مشاهده"
                           x-small>
                        <v-icon small>mdi-eye</v-icon>
                    </v-btn>

                </template>
            </v-data-table>
        </v-card>
        <v-card v-if="tableType==3" class="mt-3">
            <v-card-title>
                <v-text-field v-model="search" append-icon="mdi-magnify" hide-details label="Search"
                              single-line></v-text-field>
            </v-card-title>
            <v-data-table :headers="customerHeaders" :items="customerOrders" :search="search"
                          :sort-desc="true" sort-by="transition_number">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn :to="{ path: '/shopCustomerOrderShow/'+ item.transition_number}" color="primary" dark fab
                           title="مشاهده" x-small>
                        <v-icon small>mdi-eye</v-icon>
                    </v-btn>

                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>
<script>
    export default {
        created() {
            this.getAllOrders();
        },
        data() {
            return {
                search: '',
                tableType: '1',
                headers: [
                    {text: 'شناسه سفارش', align: 'start', value: 'transition_number'},
                    {text: 'نوع سفارش', value: 'order_type'},
                    {text: 'وضعیت', value: 'status'},
                    {text: 'عملیات:', value: 'actions', sortable: false},
                ],
                safirHeaders: [
                    {text: 'شناسه سفارش', align: 'start', value: 'transition_number'},
                    {text: 'نوع سفارش', value: 'order_type'},
                    {text: 'نام سفیر', value: 'safir_name'},
                    {text: 'شماره تماس:', value: 'tel'},
                    {text: 'وضعیت', value: 'status'},
                    {text: 'عملیات:', value: 'actions', sortable: false},
                ],
                customerHeaders: [
                    {text: 'شناسه سفارش', align: 'start', value: 'transition_number'},
                    {text: 'نام خریدار', value: 'customer_name'},
                    {text: 'شماره تماس:', value: 'tel'},
                    {text: 'عملیات:', value: 'actions', sortable: false},
                ],
                orders: [],
                safirOrders: [],
                customerOrders: [],
            }
        },
        methods: {
            getAllOrders() {
                axios.post('/shop/getAllOrders')
                    .then((data) => {
                        var list = []
                        for (const [key, value] of Object.entries(data.data)) {
                            list.push(value)
                        }
                        this.orders = list
                    })
                    .catch(() => {
                        alert('خطای ارتباط با سرور1')
                    });
                axios.post('/shop/getAllSafirOrders')
                    .then((data) => {
                        var list = []
                        for (const [key, value] of Object.entries(data.data)) {
                            list.push(value)
                        }
                        this.safirOrders = list
                    })
                    .catch(() => {
                        alert('خطای ارتباط با سرور2')
                    });
                axios.post('/shop/getAllShopCustomerOrders')
                    .then((data) => {
                        var list = []
                        for (const [key, value] of Object.entries(data.data)) {
                            list.push(value)
                        }
                        this.customerOrders = list
                    })
                    .catch(() => {
                        alert('خطای ارتباط با سرور 3')
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
