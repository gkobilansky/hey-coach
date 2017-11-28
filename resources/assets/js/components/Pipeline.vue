<template>
    <div class="pipline">
    	<ul class="drag-list">
    		<li v-for="stage in stages" class="drag-column" :class="{['drag-column-' + stage.name]: true}" :key="stage.id">
    			<span class="drag-column-header">
    				<h3 class="stage-name">{{ stage.name }}</h3>
    			</span>
    			<div class="drag-options"></div>
    			<ul class="drag-inner-list" ref="list" :data-status="stage.name">
                    <li class="drag-item" v-for="block in getBlocks(stage.id)" :data-block-id="block.id" :key="block.id">
                        <slot :name="block.id">
                          <a :href="'/recruits/' + block.id">
                            <div class="block">
                                <strong>
                                  <img src="/images/profile_120x120.svg" :title="block.name" class="mini-profile">
                                <span class="name">{{ block.name }}</span>
                                </strong>
                            
                            </div>
                          </a>
                            <!-- <div><strong>Note: </strong>{{ block.title }}</div> -->
                            <div>{{ stage.id }}</div>
                        </slot>
                    </li>
    			</ul>
    		</li>
    	</ul>
    </div>
</template>


<script>
    import dragula from 'dragula';

    export default {
      name: 'pipeline',

      props: {
        stages: {},
        blocks: {},
        contact: {}
      },
      data() {
        return {
         
        };
      },

      computed: {
        localBlocks() {
          return this.blocks;
        },
      },

      methods: {
        getBlocks(status) {
          return this.localBlocks.filter(block => block.status_id === status);
        },
         updateBlock(id, status_id) {
          this.blocks.find(b => b.id === Number(id)).status = status;
         },
      },

      mounted() {
        dragula($('.drag-inner-list').toArray())
            .on('drag', (el) => {
              el.classList.add('is-moving');
            })
            .on('drop', (block, list) => {
              let index = 0;
              for (index = 0; index < list.children.length; index += 1) {
                if (list.children[index].classList.contains('is-moving')) break;
              }
              this.$emit('update-block', block.dataset.blockId, list.dataset.status_id, index);
            })
            .on('dragend', (el) => {
              el.classList.remove('is-moving');

              window.setTimeout(() => {
                el.classList.add('is-moved');
                window.setTimeout(() => {
                  el.classList.remove('is-moved');
                }, 600);
              }, 100);
            });
      },
    };
</script>
