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

            <v-row class="mb-0 py-0 px-2">
                <v-col cols="6">
                    <v-radio-group v-model="tableType">
                        <v-row>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-radio label="
                                همه
                            " value="1" @click="getAllResumes"></v-radio>
                            &nbsp;&nbsp;&nbsp;
                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-radio label="
                            فعال
                            " value="2" @click="getActiveResumes" ></v-radio>
                            &nbsp;&nbsp;&nbsp;
                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-radio label="
                            جدید
                            " value="3" @click="getNewResumes" ></v-radio>
                            &nbsp;&nbsp;&nbsp;
                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-radio label="
                            مردود
                            " value="4" @click="getRejectedResumes" ></v-radio>
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

            <v-data-table :headers="headers" :items="resumes" :items-per-page="50" :search="search" dense
                          no-data-text="کاربری یافت نشد"
            >
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn :to="{ path: '/allResumes/'+ item.id}" color="primary" dark fab title="مشاهده" x-small>
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
        this.getAllResumes();
    },
    data() {
        return {
            tableType: "1",
            search: '',
            headers: [
                {text: 'نام:', align: 'start', value: 'name',},
                {text: 'نام خانوادگی:', value: 'last_name'},
                {text: 'شماره تماس:', value: 'tel'},
                {text: 'تاریخ ایجاد:', value: 'jalali_created_at', sortable: true},
                {text: 'تاریخ آخرین تغییر:', value: 'jalali_updated_at', sortable: true},
                {text: 'طرح', value: 'last_tarh', sortable: true},
                {text: 'عملیات:', value: 'actions', sortable: false},
            ],
            resumes: [],
        }
    },
    methods: {
        getAllResumes() {
            axios.post('/admin/getAllResumes')
                .then((data) => {
                    if (data.data) {
                        this.resumes = data.data;
                    }
                })
                .catch(() => {
                    alert("خطای سرور")
                });
        },
        getActiveResumes() {
            axios.post('/admin/getActiveResumes')
                .then((data) => {
                    if (data.data) {
                        this.resumes = data.data;
                    }
                })
                .catch(() => {
                    alert("خطای سرور")
                });
        },
        getNewResumes() {
            axios.post('/admin/getNewResumes')
                .then((data) => {
                    if (data.data) {
                        this.resumes = data.data;
                    }
                })
                .catch(() => {
                    alert("خطای سرور")
                });
        },
        getRejectedResumes() {
            axios.post('/admin/getRejectedResumes')
                .then((data) => {
                    if (data.data) {
                        this.resumes = data.data;
                    }
                })
                .catch(() => {
                    alert("خطای سرور")
                });
        },
        openResume(item) {
            this.showid = item.id;
        },
        getResumeExcel() {
            if (this.tableType === "1")
                window.open("/admin/getAllSafirResumesExcel")
            else if (this.tableType === "2")
                window.open("/admin/getActiveSafirResumesExcel")
            else if (this.tableType === "3")
                window.open("/admin/getNewSafirResumesExcel")
            else if (this.tableType === "4")
                window.open("/admin/getRejectedSafirResumesExcel")
        }
    }
}
</script>
