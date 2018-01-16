<template>
    <div class="pipline">
    	<ul class="drag-list">
    		<li v-for="stage in stages" class="drag-column" :class="{['drag-column-' + stage.name]: true}" :key="stage.id">
    			<span class="drag-column-header">
    				<h3 class="stage-name">{{ stage.name }}</h3>
    			</span>
    			<div class="drag-options"></div>
    			<ul class="drag-inner-list" ref="list" :data-status="stage.id" v-on:update-block="updateBlock(id, status_id)">
                    <li class="drag-item" v-for="block in getBlocks(stage.id)" :data-block-id="block.id" :key="block.id">
                        <slot :name="block.id">
                          <a :href="'/recruits/' + block.id">
                            <div class="block">
                                <strong>
                                <img src="/images/profile_120x120.svg" :title="block.name" class="mini-profile">
                                <p class="name">{{ block.name }}</p>
                                </strong>
                                <p class="org"><span class="glyphicon glyphicon-education" aria-hidden="true" data-toggle="tooltip"
                 title="School" data-placement="left"></span> {{ block.company_name}}<br><span class="state">{{ block.state }}</span></p>
                                
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
         updateBlock(block, stage) {

          let resource = this.$resource('recruits/updatestatus{/id}')
        //  let id = block.dataset.blockId;
          resource.get({id: 21}, {}).then(this.successCallback, this.errorCallback);

        },
        successCallback(r) {
          console.log('success', r)
        },
        errorCallback(e) {
          console.log(e)
        }
      },

      mounted() {
        dragula($('.drag-inner-list').toArray())
            .on('drag', (el) => {
              el.classList.add('is-moving');
            })
            .on('drop', (block, stage) => {
              let index = 0;
              for (index = 0; index < stage.children.length; index += 1) {
                if (stage.children[index].classList.contains('is-moving')) break;
              }
              this.updateBlock(block, stage)
              let id = block.dataset.blockId;
              console.log(block, id, stage)
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
