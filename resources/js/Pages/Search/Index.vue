<script setup>
import TypesenseInstantSearchAdapter from "typesense-instantsearch-adapter";
import "instantsearch.css/themes/algolia-min.css";

const adapter = new TypesenseInstantSearchAdapter({
  server: {
    apiKey: import.meta.env.VITE_TYPESENSE_API_KEY,
    nodes: [
      {
        host: import.meta.env.VITE_TYPESENSE_HOST,
        port: import.meta.env.VITE_TYPESENSE_PORT,
        protocol: import.meta.env.VITE_TYPESENSE_PROTOCOL
      }
    ]
  },

  additionalSearchParameters: {
    query_by: "name",
    // sort_by: "_text_match:desc,ratings_count:desc,publication_year:desc",
  }
});

const searchClient = adapter.searchClient;

</script>

<template>
  <div class="max-w-5xl mx-auto">
    <ais-instant-search :search-client="searchClient" index-name="courses" class="space-y-2">
      <div class="grid grid-cols-12 gap-8">
        <aside class="col-span-full xl:col-span-3 space-y-4">
          <ais-panel>
            <template #header>Category</template>
            <ais-refinement-list attribute="category" />
          </ais-panel>
        </aside>
        <div class="col-span-full xl:col-span-9">
          <ais-search-box v-model="searchQuery"/>
          <ais-stats
            :class-names="object" class="my-4"
          />
          <ais-hits>
            <template #item="{ item }">
              <h3 class="font-bold">
                <ais-highlight attribute="name" :hit="item" />
              </h3>
            </template>
          </ais-hits>
        </div>
      </div>
    </ais-instant-search>
  </div>
</template>

<style>
.ais-RefinementList-label,
.ais-NumericMenu-label{
  display: flex;
  gap: .5rem;
  padding: .1rem 0;
}
</style>
