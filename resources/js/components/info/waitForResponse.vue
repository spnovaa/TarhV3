<template>

    <v-dialog
        v-model="processing"
        max-height="108"
        max-width="108"
        persistent
    >
        <v-card>
            <v-card-text class="py-2">
                <v-row align="center" justify="center">
                    <v-col class="text-center">
                        <v-progress-circular
                            :size="70"
                            :width="7"
                            color="purple"
                            indeterminate
                        ></v-progress-circular>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>

</template>

<script>

export default {
    name: "waitForResponse",
    props: ['processing'],
}
</script>

<style scoped>

</style>
