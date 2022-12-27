<template>
  	<Card class="flex flex-col">
		<div class="row pt-3 pl-5">
			<label class="text-lg font-bold text-primary-500">{{__('Dump database')}}</label>
		</div>
		<div class="pl-5 pr-5 py-3">
			<input
				class="form-control border rounded w-full px-3 dark:bg-gray-900 dark:focus:bg-gray-800"
				:placeholder="__('Custom dump name')"
				v-model="dumpName"
				type="text"
			>
		</div>
    	<div class="flex items-center justify-between px-6 pt-2 pb-3 border-t border-gray-100 dark:border-gray-700">
			<div class="flex items-center">
				<input
					class="form-checkbox checkbox h-4 w-4 text-primary-500 transition duration-150 ease-in-out"
					v-model="onlyStructure"
					id="onlyStructure"
					type="checkbox"
				>
				<label
					for="onlyStructure"
					class="
						ml-2 block
						text-sm
						leading-5
						text-gray-700
						dark:text-gray-400
						font-medium
						cursor-pointer
					"
				>
					{{__('Dump structure only')}}
				</label>
			</div>
			<button
				type="button"
				size="md"
				:disabled="loading"
				class="
					flex-shrink-0
					shadow
					rounded
					focus:outline-none
					ring-primary-200
					dark:ring-gray-600
					focus:ring
					bg-primary-500
					hover:bg-primary-400
					active:bg-primary-600
					text-white
					dark:text-gray-800
					inline-flex
					items-center 
					font-bold
					px-4 h-9
					text-sm
					flex-shrink-0
				"
				@click="createDump"
			>
				<span v-if="loading">{{__('Dumping...')}}</span>
				<span v-else>{{__('Dump')}}</span>
			</button>
    	</div>
  	</Card>
</template>

<script>
import axios from 'axios';

export default {
	data() {
		return {
			onlyStructure: false,
			loading: false,
			dumpName: ''
		}
	},

	props: [
    	'card'
  	],

	methods: {
		createDump() {
			this.loading = true;
			const params = {
				onlyStructure: this.onlyStructure,
				sqlDumpPath: this.card.sqlDumpPath,
				dumpName: this.dumpName,
				dumpPath: this.card.dumpPath,
				database: this.card.database
			};

			axios.post('/nova-vendor/nova-dump-db/dump', params)
				.then(response => {
					this.dumpName = '';
					this.loading = false;
					Nova.success(response.data.message ?? 'Dump created successfully');
				})
				.catch(error => {
					this.loading = false;
					Nova.$emit('error', error.response.data.message ?? 'Something went wrong');
				});
		}
	}
}
</script>
