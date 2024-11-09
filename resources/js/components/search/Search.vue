<template>
    <div class="search">
        <div class="form-group">
            <input class="fname-input" name="search" v-model="search" maxlength="30" placeholder="Search..."
                @input="handleSearch" />
        </div>

        <div class="form-group">
            <select class="form-select" v-model="order_by" @change="onChange()">
                <option data-icon="bi bi-funnel-fill" selected value="">Select Order</option>
                <option value="desc">Newest Jobs</option>
                <option value="asc">Oldest Jobs</option>
                <!-- <option value="carpentry">Carpentry</option> -->
            </select>
        </div>
    </div>
</template>

<script>
export default {
    name: "Search",
    data() {
        return {
            search: '',
            order_by: '',
        };
    },
    methods: {
        // submitForm() {
        //     const searchData = {
        //         search: this.search,
        //         order_by: this.order_by,
        //     };
        //     this.$emit("search", searchData);
        // },

        onChange() {
            console.log("test filter data", this.order_by);
            this.emitter.emit("filter", this.order_by);
        },
        handleSearch() {
            this.emitter.emit("search", this.search);
        }
    },
};
</script>

<style scoped>
.search {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 40px;
    text-align: -webkit-right;
}

.form-group {
    flex: 1;
    min-width: 250px;
    /* Ensures a minimum width for form elements */
}

.fname-input {
    width: 100%;
    height: 50px;
    border-radius: 8px;
    border: 1px solid #707485;
    padding: 0 15px;
    box-sizing: border-box;
}


.form-select {
    width: 50%;
    height: 50px;
    border-radius: 8px;
    border: 1px solid #707485;
    padding: 0 15px;
    box-sizing: border-box;
}

.fname-input::placeholder {
    color: #888;
}

@media (max-width: 768px) {
    .search {
        flex-direction: column;
        gap: 10px;
    }

    .form-group {
        min-width: 100%;
        /* Full width on smaller screens */
    }

    .form-select {
        width: 100%;
        height: 50px;
        border-radius: 8px;
        border: 1px solid #707485;
        padding: 0 15px;
        box-sizing: border-box;
    }
}
</style>
