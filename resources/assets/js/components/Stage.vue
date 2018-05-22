<template>

	<div class="drag-column" :class="{['drag-column-' + stage.name]: true}">
		<span class="drag-column-header">
			<h3 class="stage-name">{{ stage.name }}</h3>
		</span>

		<draggable class="list-group" :options="{group:'stages'}"  :data-status="stage.id" @end="onEnd">
			<Block v-for="block in moveableBlocks"
			 	 :key="block.id"
				 :block="block" />
		</draggable>
	</div>
</template>

<script>
import Block from "./Block";
import draggable from "vuedraggable";

export default {
  name: "Stage",
  components: {
    draggable,
    Block
  },
  props: {
    stage: {},
    blocks: {}
  },
  computed: {
        moveableBlocks: function() {
          return this.blocks
        }
  },
  methods: {
	onEnd(evnt){
		  console.log(evnt)
		  let blockId = evnt.item.dataset.blockId;
		  let statusId = evnt.to.dataset.status;
		  this.updateBlock(blockId, statusId);
	  },
    updateBlock(block, stage) {
		console.log(block, stage)
      this.$store.dispatch( 'athleteData/updateRecruitStatus', {
        block,
        stage
    });
    },
    successCallback(r) {
      console.log("success", r);
      //alert("succes updatestatus " + JSON.stringify(r));
    },
    errorCallback(e) {
      console.log(e);
      //alert("error updatestatus - " + e);
    }
  }
};
</script>

<style>

</style>
