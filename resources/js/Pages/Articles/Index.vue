<template>
  <div>
    Burası resources/js/Pages/Articles/Index.vue dosyasıdır.
    <hr />
    <ul>
      <li v-for="article in articles" :key="article.id">
        {{ article.title }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["articles"],
};
</script>
