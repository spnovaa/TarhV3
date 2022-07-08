<template>
    <v-card class=" mb-10" dark>
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
<!--                            <li>-->
<!--                                <v-icon style="color:red">mdi-alert-rhombus-outline</v-icon>-->
<!--                                توجه فرمایید که سفیران طرح، تنها قادر به سفارش کتابهایی هستند که در این قسمت موجودی-->
<!--                                داشته باشند.-->
<!--                            </li>-->
                            <li>
                                <v-icon style="color:red">mdi-alert-rhombus-outline</v-icon>
                                در صورتی که وصول سفارش هایی که به شرکت پخش ارسال کرده اید را تایید کنید، ارقام تایید شده
                                به صورت خودکار در موجودی انبار شما اعمال می شوند.
                            </li>
                            <li>
                                <v-icon style="color:red">mdi-alert-rhombus-outline</v-icon>
                                در صورتی که قصد فروش کتابی از موجودی فروشگاه را دارید لازم است که نسبت به ثبت موجودی
                                فروشگاه در انبار سایت
                                اقدام کنید. در غیر اینصورت فروش شما از محل سفارشهای شرکت پخش، تلقی می گردد.
                            </li>
                            <li>
                                <v-icon style="color:red">mdi-alert-rhombus-outline</v-icon>
                                پس از ویرایش موجودی فروشگاه، در صورت اطمینان، بر روی کلید
                                <span class="red--text">
                                    ذخیره تغییرات
                                </span>
                                کلیک کنید.
                            </li>
                        </ul>
                    </h6>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>
