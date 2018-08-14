export default {
	data(){
		return {
			productStock:null,
		}
	},

	methods: {
		ls()
		{
			this.$Loading.start();
		},
		lf()
		{
			this.$Loading.finish();
		},
		le()
		{
			this.$Loading.error();
		},
		i(t,m){
			this.$Notice.info({
                title: t,
                desc: m
            });
		},
		e(t,m){
			this.$Notice.error({
                title: t,
                desc: m
            });
		},
		s(t,m){
			this.$Notice.success({
                title: t,
                desc: m
            });
		},
		w(t,m){
			this.$Notice.warning({
                title: t,
                desc: m
            });
		},
	}
}