const TelegramBot = require('node-telegram-bot-api')
const config = require('./config')
const helper = require('./helper')
const keyboard = require('./keyboard')
const kb = require('./keyboard-buttons')
const ikb = require('./inline-keyboard')
const fs = require('fs')
const fetch = require('node-fetch')  //installed npm node-fetch for api

helper.logStart()

const bot = new TelegramBot(config.TOKEN,{
    polling: true
})
var indexOf=0

bot.on('message', msg=>{
    counter=0
    const chatId = helper.getChatId(msg)
    var objHold={hold:0}
    
    switch(msg.text){
        
        case kb.home.catalogs:
            bot.sendMessage(chatId,'Каталог',{
                reply_markup:{
                    keyboard:keyboard.exit,
                    resize_keyboard:true
                }
            })
            .then(()=>{
                fetch('http://allouzb/category/get')
                    .then(response => response.json())
                    .then(data=>{
                        var send_to_root=key_value_pairs(data.data)
                        bot.sendMessage(chatId,'Выберите раздел чтобы вывести список товаров:',{
                            reply_markup:{
                                inline_keyboard:send_to_root
                            }
                        })
                    })
                
                
            })

            break
        case kb.home.bin:
            break
        case kb.home.orders:
            break
        case kb.home.news:
            fetch('http://allouzb/news/get')
            .then(response => response.json())
            .then(data=>{
            
                bot.sendChatAction(chatId,"upload_photo").then(()=>{
                console.log(data.created_at)
                    bot.sendPhoto(chatId,'.'+data.img.substr(12,data.img.length,{
                    caption: data.created_at
                    })).then(()=>{
                        bot.sendMessage(chatId,data.text,{
                            reply_markup:{
                                keyboard: keyboard.news,
                                resize_keyboard:true
                            }
                        })
                    })
                 
              }) 
            })
            break
        //more knopka bosilganda
        case kb.more.more:
            bot.sendChatAction(chatId,"upload_photo").then(()=>{
                bot.sendPhoto(chatId,'./news/news2.png') 
                .then((msg)=>{
                    bot.sendMessage(chatId,'02.02.1992'+'\n'+'Information with large image test')
                })
               })
            
            break
        

        case kb.home.help:
            bot.sendMessage(chatId,'Список команд:\n/catalog - Каталог\n\n Выберите ниже раздел справки и получите краткую помощь. Если Ваш вопрос не решен, обратитесь за помощью к живому оператору @abusaid_umarov.',{
                reply_markup:{
                    keyboard: keyboard.help,
                    resize_keyboard:true
                }
            }).then((msg)=>{messageId2 = msg.message_id})
            break
        case kb.help.call:
            bot.sendMessage(chatId,'Горячая линия "allo_uz"\n+998990000001')
            break 
        case kb.help.write:
            objHold.hold=0
            bot.sendMessage(chatId,'Напишите сообщение',
            {
                reply_markup:{
                    keyboard:keyboard.cancel,
                    resize_keyboard:true
                }
            })
            .then((msg)=>{
                messageId2 = msg.message_id
               // hold=1
                objHold.hold=1
            })
            console.log(msg.text)
            break

            
        //knopka nazad
        case kb.cancel.cancel:
            if(msg.text.toLowerCase=='отмена')
            {
                bot.deleteMessage(chatId,messageId2)
            }
            bot.sendMessage(chatId,'Список команд:\n/catalog - Каталог\n\n Выберите ниже раздел справки и получите краткую помощь. Если Ваш вопрос не решен, обратитесь за помощью к живому оператору @abusaid_umarov.',{
                reply_markup:{
                    keyboard: keyboard.help,
                    resize_keyboard:true
                }
            }).then((msg)=>{messageId2 = msg.message_id})

            break
        case kb.back.backward:
            if(msg.text.toLowerCase=='назад')
            {
                bot.deleteMessage(chatId,messageId2)
            }

            bot.sendMessage(chatId,'Главный меню',{
                reply_markup:{
                    keyboard: keyboard.home,
                    resize_keyboard: true 
                }
            })
            break
        case kb.exit.exit:
            bot.sendMessage(chatId,'Главный меню',{
                reply_markup:{
                    keyboard: keyboard.home,
                    resize_keyboard: true 
                }
            })
            break
        case kb.exit.mcatalogue:
            fetch('http://allouzb/category/get')
            .then(response => response.json())
            .then(data=>{
                var send_to_root=key_value_pairs(data.data)
                //console.log(send_to_root)
                bot.sendMessage(chatId,'Выберите один из каталогов:',{
                    reply_markup:{
                        inline_keyboard:send_to_root
                    }
                })
            })
            break
            default:{
                console.log(objHold.hold)
                if(objHold.hold==1){
                   //bazaga shu msg.text otziv ga yoziladi
                    console.log(msg.text+'this will go to DB')
                   //tugadi bazaga yozish
                    bot.sendMessage(chatId,'Спасибо за ваш отзыв!',{
                        reply_markup:{
                            keyboard:keyboard.back,
                            resize_keyboard:true
                        }
                    })
                }
                objHold.hold=0 //buyoda hold otzivni ajratish uchun kk
                
                
            }
        
    }
})








bot.on('callback_query',query=>{
    var status,sub_category
    var calculated_cost

    if(query.data.slice(0,3)=='add'){
        // console.log(query.data)
         //console.log(query.message.chat.id+'\n'+query.message.message_id)
         dataObj=query.data.split(" ")
         
         
         console.log('here add>>>>  '+dataObj[0]) //add
         console.log('here cost>>>>  '+dataObj[1]) //cost
         console.log('here id>>>>  '+dataObj[2]) //id
            counter=parseInt(dataObj[3])+1
         console.log('num of>>>> '+counter) //counter
        
         
         
         var description=dataObj.slice(4,dataObj.length).join(" ")
         
         addItemToCart(dataObj[2],dataObj[1],counter,description)
    
           bot.editMessageCaption(description,{
                chat_id:query.message.chat.id,
                message_id: query.message.message_id,
                reply_markup:{
                    inline_keyboard:[
                        [{text:'Купить - '+dataObj[1]+' UZS'+' ('+counter +'шт.)',callback_data:'add'+' '+dataObj[1]+' '+dataObj[2]+' '+counter+' '+description}],
                        [{text:'В корзину',callback_data:'bin'}]
                    ]
                }
            }).catch((err)=>{console.log(err)})
    
    
        }
        else if(query.data=='bin'){
            console.log('bin')
            console.log('look>>>>>>>>>>>>>'+JSON.stringify(cart))

            
            calculated_cost = cart[0].cost*cart[0].count
            bot.sendMessage(query.message.chat.id,'Корзина:\n '+cart[0].cost+' UZS '+' x '+cart[0].count+' = '+calculated_cost+' UZS ',{
                reply_markup:{
                    inline_keyboard: ikb.cartKeyboard
                }
            }).then(()=>{
                //id berib url_pic olish
            })
            console.log('PREV message_id:>>  '+query.message.message_id)
    
        }else if(query.data=='❌'){
            removeItemFromCart(dataObj[2])
            console.log('cart '+JSON.stringify(cart))
        }
        else if(query.data=='▶️'){
            indexOf++;
            console.log('indexOf*** '+indexOf)
            bot.editMessageText('Корзина:\n '+cart[indexOf].cost+' UZS '+' x '+cart[indexOf].count+' = '+calculated_cost+' UZS ',{
                chat_id: query.message.chat.id,
                message_id:query.message.message_id,
                reply_markup:{
                    inline_keyboard:ikb.cartKeyboard
                }
            })
        }
        else if(query.data=='🔻'){
            console.log('indexOf*** '+indexOf)
            if(cart[indexOf].count!=1){
                decrementItemInCart(dataObj[2])
                calculated_cost = cart[indexOf].cost*cart[indexOf].count
                bot.editMessageText('Корзина:\n '+cart[indexOf].cost+' UZS '+' x '+cart[indexOf].count+' = '+calculated_cost+' UZS ',{
                    chat_id: query.message.chat.id,
                    message_id:query.message.message_id,
                    reply_markup:{
                        inline_keyboard:ikb.cartKeyboard
                    }
                })
            }else{console.log('1ta qoldi')}

            /*
            console.log('THEN message_id:>>  '+query.message.message_id)
            console.log('cart[0].id>>  '+cart[0].id)
            console.log('dataObj[2]>>  '+dataObj[2])
            console.log('cart>>>>> '+JSON.stringify(cart))*/
            
        }else if(query.data == '🔺'){
            console.log('indexOf**** '+indexOf)
            
            incrementItemInCart(dataObj[2])
            calculated_cost = cart[indexOf].cost*cart[indexOf].count
            
            console.log('Qara buyoga>>>>>>>'+calculated_cost)
                
            bot.editMessageText('Корзина:\n '+cart[indexOf].cost+' UZS '+' x '+cart[indexOf].count+' = '+calculated_cost+' UZS ',{
                chat_id: query.message.chat.id,
                message_id:query.message.message_id,
                reply_markup:{
                    inline_keyboard:ikb.cartKeyboard
                }
            })

        }
        else{

        
        /*else{
            var goods = ikb[query.data]
            var good_counter=0
            goods.forEach((good)=>{
                good_counter=good_counter+1
                //console.log(good)
                bot.sendPhoto(query.message.chat.id,good.picture,{
                    caption:good.description,
                    reply_markup:{
                        inline_keyboard:[
                            [{text:'Купить - '+good.cost+' UZS' ,callback_data:'add'+' '+good.cost+' '+good.id+' '+counter+' '+good.description}]
                        ]
                    }
                })
                .then(()=>{
                    
                    bot.sendMessage(query.message.chat.id,'Показано __ товара из '+good_counter)
                    //console.log(query.message.chat.id+'\n'+query.message.message_id)
                }).catch((err)=>{console.log(err)})
                
            })
        }*/
        //////////////////////////////////////////////////////



    
    fetch(`http://allouzb/category/get?id=${query.data}`)
        .then(response => response.json())
        .then(data=>{
            
            status = data.status //0 -keyboard yoki 1-good
            sub_category = key_value_pairs(data.data) //keyobard
            //callback_data = query.data  //callback_data bu id shuni id ga berish kk
            
        if(data.parent!=null){
            sub_category.push([{text:'↖️ Вернуться в суб-каталог',callback_data:data.parent}])
        }
            
            //keyboard holati uchun
        if(status==0){
            console.log('status 0 keyobard')
            
            bot.deleteMessage(query.message.chat.id,query.message.message_id)
            .then(()=>{
                bot.sendMessage(query.message.chat.id,'Выберите раздел чтобы вывести список товаров:',{
                    reply_markup:{
                        inline_keyboard:sub_category, //shuyoga api digi DATA ni assign
                    }
                })
                
            })

        }
        //data holati uchun
        else if(status==1){
            console.log('status 1 data')
            var goods = data.data
            var good_counter=0
            
            goods.forEach((good)=>{
                good_counter=good_counter+1
                //console.log('IMAGE  *****'+good.img)
                bot.sendChatAction(query.message.chat.id,'upload_photo')
                .then(()=>{
                    bot.sendPhoto(query.message.chat.id,'.'+good.img.substr(12,good.img.length),{
                        caption:good.description,
                        reply_markup:{
                            inline_keyboard:[
                                [{text:'Купить - '+good.cost+' UZS' ,callback_data:'add'+' '+good.cost+' '+good.id+' '+counter+' '+good.description}]
                            ]
                        }
                    })
                    .then(()=>{
                        bot.sendMessage(query.message.chat.id,'Показано __ товара из '+good_counter)
                        //console.log(query.message.chat.id+'\n'+query.message.message_id)
                        }).catch((err)=>{console.log(err)})
                })
            })


        }
        

        else{
            console.log('status is not either 0 or 1\nэта категория пока пуста')
            bot.sendMessage(query.message.chat.id,'⚠️ Извините, эта категория пока пуста!')
        }
        
       }) 
    
    }
//////////////////////////////////////////////////////////////////////////////
    /*if(query.data.slice(0,2)=='sc'){
        bot.deleteMessage(query.message.chat.id,query.message.message_id)
        .then(()=>{
            bot.sendMessage(query.message.chat.id,'Выберите раздел чтобы вывести список товаров:',{
                reply_markup:{
                    inline_keyboard:ikb[query.data]
                }
            })
        })
        
    }*/
    
    
     


})







bot.onText(/\/start/,msg=>{
    const text = `Добро пожаловать на наш магазин ${msg.from.first_name}\nВыберетье команду:`
    bot.sendMessage(helper.getChatId(msg),text,{
        reply_markup:{
            keyboard: keyboard.home,
            resize_keyboard: true 
        }
    })
})



//functions
        var cart = []
        var Item = function(id,cost,count,description){
            this.id = id
            this.cost = cost
            this.count = count
            this.description = description
        }
        function removeItemFromCart(id){
            for(var i in cart){
                if(cart[i].id===id){
                    cart.splice(i,1);
                    break;
                }
            }
        }
        function incrementItemInCart(id){
            for(var i in cart){
                if(cart[i].id===id){
                    cart[i].count++;
                    break
                }
            }
        }
        function decrementItemInCart(id){
            for(var i in cart){
                if(cart[i].id===id){
                    if(cart[i].count>1){
                        cart[i].count--;
                    }else{
                        console.log('at least 1 item you should posess')
                        break
                    }    
                    break
                }
            }
        }
        
        function addItemToCart(id,cost,count,description){
            for(var i in cart){
                if(cart[i].id === id){
                    cart[i].count ++;
                    return
                }
            }
            var item = new Item(id,cost,count,description);
            cart.push(item);
        }




//////////////```Plugins```///////////////////////////
function key_value_pairs(obj) 
   {
    var keys = _keys(obj);
    var length = keys.length;
    var pairs = Array(length);
    for (var i = 0; i < length; i++) 
    {
      pairs[i] = [obj[keys[i]]];
    }
    return pairs;
  }

function _keys(obj) 
  {
    if (!isObject(obj)) return [];
    if (Object.keys) return Object.keys(obj);
    var keys = [];
    for (var key in obj) if (_.has(obj, key)) keys.push(key);
    return keys;
  }
 function isObject(obj) 
 {
    var type = typeof obj;
    return type === 'function' || type === 'object' && !!obj;
  }