<style scoped>
.center{
    text-align:center;
}
.color-green{
    width: 100px;
    height: 30px;
    border-radius: 3px;
    float: left;
    position: relative;
    top: 15px;
    left: 20px;
}
.color-red{
    width: 420px;
    margin: 0 auto;
    margin-right: 10px;
}
.marginB
{
    margin-bottom: 24px;
}
</style>
<template>
    <Row>
        <Col span="22" offset="1"  class="marginB">
            <Card class="center">
                <DatePicker v-model="date" type="date" placeholder="Select date" @on-change="changeBooking"></DatePicker>
            </Card>
        </Col>
        <Row :gutter="20"  v-if="date">

            <Col span="4" v-for="(data,i) in dataRoom" :key="i"  >
            <span @click="clicked(i)">

                <Alert v-if="dataRoom[i].status==1" type="info"  show-icon>
                    #{{ data.number }} - {{ data.name }}

                    <p slot="desc"> Number Capacity: {{ data.capacity }}</p>
                    <p slot="desc"> Rent: {{ data.rent }}</p>
                    <p slot="desc"> Info: {{ data.remarks }}</p>
                </Alert>
                <Alert v-else-if="dataRoom[i].status==2" type="success"  show-icon>
                    #{{ data.number }} - {{ data.name }}

                    <p slot="desc"> Number Capacity: {{ data.capacity }}</p>
                    <p slot="desc"> Rent: {{ data.rent }}</p>
                    <p slot="desc"> Info: {{ data.remarks }}</p>
                </Alert>
                <Alert v-else-if="dataRoom[i].status==0" type="error"  show-icon>
                    #{{ data.number }} - {{ data.name }}

                    <p slot="desc"> Number Capacity: {{ data.capacity }}</p>
                    <p slot="desc"> Rent: {{ data.rent }}</p>
                    <p slot="desc"> Info: {{ data.remarks }}</p>
                </Alert>

                    </span>
            </Col>

        </Row>
        <Col  span="14" offset="5"  v-if="date" >
            <Card>
                <Alert  class="center">New Booking
                <span slot="desc"></span>
                </Alert >
                <Tabs value="name1" >
                    <TabPane label="New Guest" name="name1">
                    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top">
                        <FormItem label="Name" prop="name">
                            <Input v-model="formValidate.name" placeholder="Enter name"></Input>
                        </FormItem>
                        <FormItem label="Phone" prop="phone">
                            <Input v-model="formValidate.phone" placeholder="Enter contact number"></Input>
                        </FormItem>
                        <FormItem label="ID"  prop="nid">
                            <Input v-model="formValidate.nid" placeholder="Enter NID/PASSPORT/DRIVING LICENSE"></Input>
                        </FormItem>
                        <FormItem label="E-mail" prop="mail">
                            <Input v-model="formValidate.mail" placeholder="Enter e-mail"></Input>
                        </FormItem>
                        <FormItem label="Birth date">
                                <DatePicker type="date" placeholder="Select date"  @on-change="dateConverter" ></DatePicker>
                        </FormItem>
                        <FormItem label="Address" prop="address">
                            <Input v-model="formValidate.address" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter full address..."></Input>
                        </FormItem>
                        <FormItem label="Gender" prop="gender">
                            <RadioGroup v-model="formValidate.gender">
                                <Radio label="male" >Male</Radio>
                                <Radio label="female">Female</Radio>
                            </RadioGroup>
                        </FormItem>
                        <FormItem label="Check In & Out">
                                <DatePicker type="date" placeholder="Choose date range"  @on-change="checkDates" ></DatePicker>
                                <!--<DatePicker type="date" placeholder="Check Out"  @on-change="dateConverter" ></DatePicker>-->
                        </FormItem>
                        <FormItem label="Room Numbers">
                            <Input v-model="formValidate.phone" placeholder="Enter numbers"></Input>
                        </FormItem>
                        <FormItem>
                            <Button type="primary" @click="addGuest">Add</Button>
                            <Button @click="handleReset('formValidate')" style="margin-left: 8px">Reset</Button>
                        </FormItem>
                    </Form>
                    </TabPane>
                    <TabPane label="Existing Guest" name="name2">On Process</TabPane>
                </Tabs>

            </Card>
        </Col>

    </Row>
</template>
<script>
    export default {
        data () {
            return {
                roomCheck:[

                ]
                ,
                single:false,
                day:false,
                night:false,
                date:'',
                options3: {
                    disabledDate (date) {
                        return date && date.valueOf() < Date.now() - 86400000;
                    }
                },
                options4: {
                    disabledDate (date) {
                        const disabledDay = date.getDate();
                        return disabledDay === 15;
                    }
                },
                bookingList:[],
                dataRoom:[],
                formValidate: {
                    name: '',
                    mail: '',
                    number: '',
                    hall: '',
                    type: '',
                    address: '',
                    date:'',
                    room:[],
                },
                type: [
                    {
                        value: 'wedding',
                        label: 'Wedding'
                    },
                    {
                        value: 'reciption',
                        label: 'Reciption'
                    },

                    {
                        value: 'holdu',
                        label: 'Holdu'
                    },
                    {
                        value: 'birthday',
                        label: 'Birthday'
                    },
                    {
                        value: 'corporate',
                        label: 'Corporate'
                    },
                    {
                        value: 'others',
                        label: 'Others'
                    }
                ],
                ruleValidate: {
                    name: [
                        { required: true, message: 'The name cannot be empty', trigger: 'blur' }
                    ],
                    number: [
                        { required: true, message: 'The number cannot be empty', trigger: 'blur' }
                    ],
                    hall: [
                        { required: true, message: 'Please select the hall', trigger: 'change' }
                    ],
                }
            }
        },
        methods: {
            clicked(i)
            {
                console.log(this.dataRoom[i].status)
                // if(this.dataRoom[i].status==2)
                // {
                // this.dataRoom[i].status=1
                // this.formValidate.room.splice(i,1)
                // }
                if(this.dataRoom[i].status==1)
                {
                this.formValidate.room.push(this.dataRoom[i])
                this.dataRoom[i].status=2
                }


            },
            async changeBooking (key) {
                if(this.date)
                {
                this.ls();
                try{
                let {data} =await  axios({
                    method: 'get',
                    url:`/app/bookingFinder/${key}`
                })
                console.log(data)
                for(let d of this.dataRoom)
                {

                        d.status=1
                    for(let f of data)
                    {
                        if(f.room==d.number)
                        {
                        d.status=0
                        }

                    }

                }

                this.bookingList=data
                this.lf();
                }catch(e){
                    this.e('Oops!','Something went wrong, please try again!')
                this.le();
                }

                }
            },
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!', 'Data Added');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            handleReset (name) {
                this.$refs[name].resetFields();
            }
        },
        async created()
        {
            this.ls();
            try{
                let {data} =await  axios({
                    method: 'get',
                    url:'/app/room'
                })
                this.dataRoom=data;

            }catch(e){
                this.e('Oops!','Something went wrong, please try again!')
                this.le();
            }
            try{
                let {data} =await  axios({
                    method: 'get',
                    url:'/app/guest'
                })
                this.dataGuest=data;
                this.lf();

            }catch(e){
                this.e('Oops!','Something went wrong, please try again!')
                this.le();
            }

        }
    }
</script>
