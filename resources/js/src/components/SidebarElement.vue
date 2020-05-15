<template>
    <a :href="link ? link : '#'">
        <v-list-item link>
            <v-list-item-content>
                <div class="my-2" v-text="text"></div>
            </v-list-item-content>
        </v-list-item>
    </a>
</template>

<script>
    export default {
        props: {
            link: String|Boolean,
            text: String,
        }
    }
</script>
