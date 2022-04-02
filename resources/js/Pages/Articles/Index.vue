<template>
  <app-layout title="Articles">
    <template #header>
      <div class="flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Articles
        </h2>
        <Link :href="route('articles.create')" class="ml-auto">
          <jet-button type="button"> Create a New Article </jet-button>
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-4">
            <Link
              :href="route('articles.show', article)"
              v-for="article in articles"
              :key="article.id"
              class="
                block
                my-2
                hover:text-indigo-400
                transition
                ease-in-out
                duration-150
              "
            >
              {{ article.title }}
            </Link>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";

export default defineComponent({
  props: ["articles"],
  components: {
    AppLayout,
    Link,
    JetButton,
  },
});
</script>
