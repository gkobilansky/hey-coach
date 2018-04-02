<template>
    <div class="pipeline">
    	<div class="drag-list">
        <div class="column-wrapper">
          <Stage v-for="stage in stages"
          :key="stage.id"
          :stage="stage"
          :blocks="getStageBlocks(stage.id)" />
        </div> 
    	</div>  <!-- .drag-list -->
    </div>
</template>


<script>
    import Stage from './Stage'

    export default {
      name: 'pipeline',
      components: {
        Stage
      },

      props: {
        stages: {},
        blocks: {}
      },
      data() {
        return {
        };
      },
      mounted() {
      },
      computed: {
        localBlocks() {
          return this.blocks;
        }
      },
      methods: {
       	getStageBlocks(status_id) {
			    return this.localBlocks.filter(block => block.status_id === status_id);
		  },
   
      }
    };
</script>
