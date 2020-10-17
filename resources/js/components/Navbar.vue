<template>
<nav>
    <v-app-bar app color="indigo" dark>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title v-show="!drawer" >Books System</v-toolbar-title>
    </v-app-bar>

    <v-navigation-drawer app absolute v-model="drawer">
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="title">
                    Books
                </v-list-item-title>
                <v-list-item-subtitle>
                    System
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list dense nav>
            <v-list-item v-for="item in items" :key="item.title" router :to="item.route">
                <v-list-item-icon>
                    <v-icon> {{ item.icon }} </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title> {{ item.title }} </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</nav>
</template>

<script>
export default {
    data() {
        return {
            drawer: true,
            items: [{
                    title: 'Category',
                    icon: 'mdi-view-dashboard',
                    route : 'category'
                },{
                    title : 'Book',
                    icon : 'mdi-view-dashboard',
                    route : 'book'
                }
            ],
        }
    }

}
</script>

<style>

</style>
