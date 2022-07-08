<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    hide-details
                    label="Search"
                    single-line
                ></v-text-field>
            </v-card-title>

            <v-row class="mb-0 pb-0">
                <v-col cols="6">
                    <v-radio-group v-model="tableType" @change="getResumes">
                        <v-row>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-radio label="
                                همه
                            " value="1"></v-radio>
                            &nbsp;&nbsp;&nbsp;
                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-radio label="
                            فعال
                            " value="2"></v-radio>
                            &nbsp;&nbsp;&nbsp;
                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-radio label="
                            جدید
                            " value="3"></v-radio>
                            &nbsp;&nbsp;&nbsp;
                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-radio label="
                            مردود
                            " value="4"></v-radio>
                            &nbsp;&nbsp;&nbsp;
                            <v-divider class="mx-4" inset vertical></v-divider>

                        </v-row>
                    </v-radio-group>
                </v-col>

                <v-col cols="6">
                    <v-btn class="mx-3" color="#33691E" dark @click="getResumeExcel">
                        <v-icon>mdi-microsoft-excel</v-icon>
                    </v-btn>
                </v-col>

            </v-row>
            <v-divider class="mt-0" horizontal></v-divider>

            <v-data-table :headers="headers" :items="resumes" :search="search">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn :to="{ path: '/allShopResumes/'+ item.id}" class="mx-1" color="primary" dark fab
                           title="رزومه" x-small>
                        <v-icon small>mdi-eye</v-icon>
                    </v-btn>
                    <v-btn :to="{ path: '/adminShopStats/'+ item.id}" class="mx-1" color="cyan" dark fab title="آمار"
                           x-small>
                        <v-icon small>mdi-poll</v-icon>
                    </v-btn>
                </template>

            </v-data-table>
        </v-card>
    </v-container>
</template>
<script>
export default {
    created() {
        this.getResumes();
    },
    data() {
        return {
            tableType:"1",
            postURL:'',
            search: '',
            headers: [
                {text: 'نام:', align: 'start', value: 'name',},
                {text: 'نام خانوادگی:', value: 'last_name'},
                {text: 'نام فروشگاه:', value: 'shop_name'},
                {text: 'شماره تماس:', value: 'tel'},
                {text: 'عملیات:', value: 'actions', sortable: false},
            ],
            resumes: [],
        }
    },
    methods: {
        getResumes(){
            if (this.tableType==="1")
                this.postURL='/admin/getAllShopResumes'
            else if (this.tableType==="2")
                this.postURL='/admin/getActiveShopResumes'
            else if (this.tableType==="3")
                this.postURL='/admin/getNewShopResumes'
            else if (this.tableType==="4")
                this.postURL='/admin/getRejectedShopResumes'

            axios.post(this.postURL)
                .then((data) => {
                    if (data.data) {
                        this.resumes = data.data;
                    }
                })
                .catch(() => {
                    alert("خطای سرور")
                });
        },
        getResumeExcel() {
            if (this.tableType === "1")
                window.open("/admin/getAllShopResumesExcel")
            else if (this.tableType === "2")
                window.open("/admin/getActiveShopResumesExcel")
            else if (this.tableType === "3")
                window.open("/admin/getNewShopResumesExcel")
            else if (this.tableType === "4")
                window.open("/admin/getRejectedShopResumesExcel")
        },

    }
}
</script>
