import{T as w,o as m,b as n,w as i,d as t,u as s,Z as b,c as y,t as x,e as d,a,i as k,f as u,n as h,g as V}from"./app-0kNbx151.js";import{_ as v}from"./Checkbox-Cgvb1Sn8.js";import{_ as B}from"./GuestLayout-COGcit37.js";import{_ as c,a as f,b as p}from"./TextInput-C4Ma8Xxm.js";import{P as $}from"./PrimaryButton-DCaDcoyw.js";import"./ApplicationLogo-B0T0m6sM.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const N={key:0,class:"mb-4 font-medium text-sm text-green-600"},P={class:"mt-4"},q={class:"block mt-4"},C={class:"flex items-center"},S=a("span",{class:"ms-2 text-sm text-gray-600"},"パスワードを記憶する",-1),U={class:"flex items-center justify-end mt-4"},L={__name:"Login",props:{canResetPassword:{type:Boolean},status:{type:String}},setup(l){const e=w({email:"",password:"",remember:!1}),_=()=>{e.post(route("login"),{onFinish:()=>e.reset("password")})};return(g,o)=>(m(),n(B,null,{default:i(()=>[t(s(b),{title:"ログイン"}),l.status?(m(),y("div",N,x(l.status),1)):d("",!0),a("form",{onSubmit:V(_,["prevent"])},[a("div",null,[t(c,{for:"email",value:"メールアドレス"}),t(f,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":o[0]||(o[0]=r=>s(e).email=r),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),t(p,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),a("div",P,[t(c,{for:"password",value:"パスワード"}),t(f,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":o[1]||(o[1]=r=>s(e).password=r),required:"",autocomplete:"current-password"},null,8,["modelValue"]),t(p,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),a("div",q,[a("label",C,[t(v,{name:"remember",checked:s(e).remember,"onUpdate:checked":o[2]||(o[2]=r=>s(e).remember=r)},null,8,["checked"]),S])]),a("div",U,[l.canResetPassword?(m(),n(s(k),{key:0,href:g.route("password.request"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:i(()=>[u(" パスワードを忘れた場合 ")]),_:1},8,["href"])):d("",!0),t($,{class:h(["ms-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:i(()=>[u(" ログイン ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{L as default};
