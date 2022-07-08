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
            <v-data-table :headers="headers" :items="resumes" :search="search">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn :to="{ path: '/newDistResumes/'+ item.id}" color="primary" dark fab title="مشاهده" x-small>
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
        this.getNewDistResumes();
    },
    data() {
        return {
            search: '',
            headers: [
                {text: 'نام شرکت:', value: 'company_name'},
                {text: 'شماره تماس:', value: 'tel'},
                {text: 'مشاهده:', value: 'actions', sortable: false},
            ],
            resumes: [],
        }
    },
    methods: {
        getNewDistResumes() {
            axios.post('/admin/getNewDistResumes')
                .then((data) => {
                    if (data.data) {
                        this.resumes = data.data;
                    }
                })
                .catch(() => {
                    alert("خطای سرور")
                });
        },

    }
}
</script>
