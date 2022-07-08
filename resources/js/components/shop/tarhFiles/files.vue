<style scoped>

.heading {
    color: white;
    padding-top: 30px;
    padding-bottom: 30px;
    text-align: center;
    line-height: 1.5;
}
</style>
<template>
    <v-container class="ma-1 grey lighten-2 pa-1" fluid>

        <v-card class=" px-md-10 px-xs-2 py-5 ma-2 boxborder" height="100%" width=100%>
            <v-sheet class="success mt-n10 mb-3" style="border-radius:4px">
                <h4 class="heading">
                    اطلاعات و فایل های مورد نیاز
                </h4>
            </v-sheet>
            <v-card-text class="text-right">
                <h5>
                    در این قسمت میتوانید فایل های مربوط به مسابقه/طرح فعلی را دانلود نمایید
                </h5>
                <v-divider></v-divider>
                <h6 class="ma-5">
                    <v-icon>mdi-cloud-download</v-icon>
                    جهت دانلود فایلهای مربوط به
                    <span style="color: red">
                        مسابقه ی کتابفروشی تنها گریه کن
                    </span>
                    <span style="font-weight: bold; color:blue">
                        <a href="https://tarh.khooshe.org/files/1.zip">
                        اینجا
                            </a>
                    </span>
                    کلیک کنید
                </h6>
                <h6 class="ma-5">
                    <v-icon>mdi-cloud-download</v-icon>
                    جهت دانلود فایلهای مربوط به
                    <span style="color: red">
                        مسابقه ی کتابفروشی تندتر از عقربه ها حرکت کن
                    </span>
                    <span style="font-weight: bold; color:blue">
                        <a href="https://tarh.khooshe.org/files/2.zip">
                        اینجا
                        </a>
                    </span>
                    کلیک کنید
                </h6>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
export default {

    data() {
        return {}
    },
}
</script>
