<template>
  <div class="drag-item" :data-block-id="block.id">
      <a :href="'/recruits/' + block.id">
        <div class="block">
          <strong>
            <img src="/images/profile_120x120.svg" :title="block.name" class="mini-avatar">
            <p class="name">{{ block.name }}</p>
          </strong>
          <p class="location">
            <span class="glyphicon glyphicon-education" aria-hidden="true" data-toggle="tooltip" title="School" data-placement="left"></span> {{ block.company_name}}
            <br>
            <span class="state">{{ block.state }}</span>
          </p>
        </div>
      </a>
  </div>
</template>

<script>


export default {
  name: "Block",
  components: {
  },
  props: ["block"],
  methods: {
   
  }
};
</script>

<style>

</style>
