<template>

    <div>

        <section class="posts">
            <div class="container">
                <div class="row row-cols-3">
                    <div class="col" v-for="post in posts" :key="post.id">
                        <div class="product card">
                            <img :src="post.cover_image" :alt="post.title">
                            <div class="card-body">
                                <h3>{{post.title}}</h3>
                                <p>{{post.content}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </div>

</template>

<script>
export default {
    name: 'App',
    components: {},
    data() {
        return {
            posts: ''
        }
    },
    methods: {
        getAllPosts() {
            axios
                .get('/api/posts')
                .then((response) => {
                    console.log(response);
                    this.posts = response.data;
                })
                .catch(e => {
                    console.error(e);
                })
        }
    },
    mounted() {
        console.log('mounted');
        this.getAllPosts();
    }
}
</script>