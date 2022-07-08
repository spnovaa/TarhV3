<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <v-card>
            <v-card-title>
                <v-text-field v-model="search" append-icon="mdi-magnify" hide-details label="Search"
                              single-line></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="orders" :search="search" :sort-desc="true"
                          sort-by="transition_number">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn :to="{ path: '/orderShow/'+ item.transition_number}" color="primary" dark fab title="مشاهده"
                           x-small>
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
                headers: [
                    {text: 'فروشگاه', align: 'start', value: 'shop_name',},
                    {text: 'شناسه سفارش', value: 'transition_number'},
                    {text: 'نوع سفارش', value: 'order_type'},
                    {text: 'شماره تماس:', value: 'tel'},
                    {text: 'وضعیت', value: 'status'},
                    {text: 'عملیات:', value: 'actions', sortable: false},
                ],
                orders: [],
            }
        },
        methods: {
            getAllOrders() {
                axios.post('/distributor/getAllOrders')
                    .then((data) => {
                        var list = []
                        for (const [key, value] of Object.entries(data.data)) {
                            list.push(value)
                        }
                        this.orders = list
                    })
                    .catch(() => {
                        this.logout();
                    });
            },

        }
    }
</script>
