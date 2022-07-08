<template>
    <v-row justify="space-around">

        <v-col cols="auto">
            <v-dialog
                max-width="600"
                transition="dialog-top-transition"
            >
                <template v-slot:default="dialog">
                    <v-card>
                        <v-toolbar
                            color="primary"
                            dark
                        >
                            ارسال رزومه
                        </v-toolbar>
                        <v-card-text>
                            <div class="text-h2 pa-12">
                                کاربر گرامی! اطلاعات شما بر اساس مشارکت قبلی شما در سامانه موجود است.
                                در صورت تمایل میتوانید
                            </div>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn
                                text
                                @click="dialog.value = false"
                            >Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-dialog>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "AlreadyRegisteredDialog"
}
</script>

<style scoped>

</style>
