<template>
    <h1 class="text-center mt-4 mb-4">News</h1>

    <div class="container row mx-auto">
        <div class="col-12 col-md-6">
            <label for="title-search">Title:</label>
            <input id="title-search" class="form-control" type="text" @input="page = 1" v-model="searchTitle">
            <label for="cont-search">Contents:</label>
            <input id="cont-search" class="form-control" type="text" @input="page = 1" v-model="searchContent">

        </div>
        <div class="col-12 col-md-6">

            <label for="date-search">Date:</label>
            <div class="input-group">
                <input id="date-search" class="form-control" type="date" @input="page = 1" v-model="searchDate">
                <button class="btn btn-warning" v-if="searchDate != ''" @click="searchDate = ''; page = 1">Reset
                    Date</button>
            </div>

            <label for="select-search">Category:</label>
            <select id="select-search" class="form-select" @change="page = 1" v-model="searchCategory">
                <option value="all" selected>All</option>
                <option value="blog" selected>Blog</option>
                <option value="update">Update</option>
                <option value="pricing">Pricing</option>
                <option value="disclosure">Disclosure</option>
                <option value="world">World</option>
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="container">
            <div class="row">
                <div v-for="item in filteredNews.slice((this.page - 1) * 10, ((this.page - 1) * 10) + 10)"
                    class="col-12 col-md-6">
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between">
                            <span class="ms-2">{{ item.title }}</span>
                            <span class="me-2">{{ item.category }}</span>
                        </div>
                        <div class="card-body">
                            {{ item.content }}
                        </div>
                        <div class="card-footer p-1">
                            <span class="ms-2">{{ item.date }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <button class="btn btn-secondary my-3" v-if="page > 1" @click="page--">Previous Page</button>
                </div>
                <div class="col-12 col-md-6">
                    <button class="btn btn-secondary ms-auto my-3" v-if="isMaxPage" @click="page++">Next Page</button>
                </div>
            </div>
        </div>
    </div>


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
