<template>
    <h1>News</h1>
    <input type="text" @input="page = 1" v-model="searchTitle">
    <input type="text" @input="page = 1" v-model="searchContent">
    <input type="date" @input="page = 1" v-model="searchDate">
    <button v-if="searchDate != ''" @click="searchDate = ''; page = 1">Reset Date</button>
    <select @change="page = 1" v-model="searchCategory">
        <option value="all" selected>All</option>
        <option value="blog" selected>Blog</option>
        <option value="update">Update</option>
        <option value="pricing">Pricing</option>
        <option value="disclosure">Disclosure</option>
        <option value="world">World</option>
    </select>
    <div v-for="item in filteredNews.slice((this.page - 1) * 10, ((this.page - 1) * 10) + 10)">
        {{ item.title }}
        {{ item.date }}
        {{ item.category }}
        {{ item.content }}
    </div>
    <button v-if="page > 1" @click="page--">Previous Page</button>
    <button v-if="isMaxPage" @click="page++">Next Page</button>
</template>

<script>
import data from '@/assets/news.json'

export default {
    data() {
        return {
            news: data,
            page: 1,
            searchCategory: "all",
            searchDate: "",
            searchTitle: "",
            searchContent: "",
        }
    },
    computed: {
        filteredNews() {
            return this.news.filter(item =>
                (item.title.toLowerCase().includes(this.searchTitle.toLowerCase())) &&
                (item.content.toLowerCase().includes(this.searchContent.toLowerCase())) &&
                (item.category.toLowerCase() === this.searchCategory || this.searchCategory == "all") &&
                (item.date == this.searchDate || this.searchDate == "")
            )
        },
        isMaxPage() {
            return (Math.ceil(this.filteredNews.length / 10) > this.page)
        }
    }
}
</script>

<style scoped></style>
