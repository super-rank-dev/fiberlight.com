<?php if (!defined('ABSPATH')) exit; ?>
<div class="wrap swpm-admin-menu-wrap">
	<h1>Setup Stopwords for <?php echo wpbot_text(); ?></h1>
	
	<form method="post" action="admin.php?page=stop-word">
	<table class="form-table">

		<tr valign="top">
			<th scope="row">Language</th>
			<td>
				
				<select class="form-control" style="width:300px;" id="qlcd_wp_chatbot_stop_words_name" name="qlcd_wp_chatbot_stop_words_name">
					<option value="english" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'english') { echo "selected";} ?> ><?php echo esc_html__('English', 'wpchatbot'); ?></option>
					<option value="arabic" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'arabic') { echo "selected";} ?> ><?php echo esc_html__('Arabic', 'wpchatbot'); ?></option>
					<option value="bulgarian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'bulgarian') { echo "selected";} ?> ><?php echo esc_html__('Bulgarian', 'wpchatbot'); ?></option>
					<option value="czech" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'czech') { echo "selected";} ?> ><?php echo esc_html__('Czech', 'wpchatbot'); ?></option>
					<option value="catalan" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'catalan') { echo "selected";} ?> ><?php echo esc_html__('Catalan', 'wpchatbot'); ?></option>
					<option value="danish" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'danish') { echo "selected";} ?> ><?php echo esc_html__('Danish', 'wpchatbot'); ?></option>
					<option value="dutch" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'dutch') { echo "selected";} ?> ><?php echo esc_html__('Dutch', 'wpchatbot'); ?></option>
					<option value="finnish" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'finnish') { echo "selected";} ?> ><?php echo esc_html__('Finnish', 'wpchatbot'); ?></option>
					<option value="french" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'french') { echo "selected";} ?> ><?php echo esc_html__('French', 'wpchatbot'); ?></option>
					<option value="german" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'german') { echo "selected";} ?> ><?php echo esc_html__('German', 'wpchatbot'); ?></option>
					<option value="hindi" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'hindi') { echo "selected";} ?> ><?php echo esc_html__('Hindi', 'wpchatbot'); ?></option>
					<option value="hungarian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'hungarian') { echo "selected";} ?> ><?php echo esc_html__('Hungarian', 'wpchatbot'); ?></option>
					<option value="indonesian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'indonesian') { echo "selected";} ?> ><?php echo esc_html__('Indonesian', 'wpchatbot'); ?></option>
					<option value="italian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'italian') { echo "selected";} ?> ><?php echo esc_html__('Italian', 'wpchatbot'); ?></option>
					<option value="norwegian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'norwegian') { echo "selected";} ?> ><?php echo esc_html__('Norwegian', 'wpchatbot'); ?></option>
					<option value="persian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'persian') { echo "selected";} ?> ><?php echo esc_html__('Persian', 'wpchatbot'); ?></option>
					<option value="polish" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'polish') { echo "selected";} ?> ><?php echo esc_html__('Polish', 'wpchatbot'); ?></option>
					<option value="portuguese" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'portuguese') { echo "selected";} ?> ><?php echo esc_html__('Portuguese', 'wpchatbot'); ?></option>
					<option value="romanian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'ukrainian') { echo "selected";} ?> ><?php echo esc_html__('Romanian', 'wpchatbot'); ?></option>
					<option value="russian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'russian') { echo "selected";} ?> ><?php echo esc_html__('Russian', 'wpchatbot'); ?></option>
					<option value="slovak" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'slovak') { echo "selected";} ?> ><?php echo esc_html__('Slovak', 'wpchatbot'); ?></option>
					<option value="spanish" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'spanish') { echo "selected";} ?> ><?php echo esc_html__('Spanish', 'wpchatbot'); ?></option>
					<option value="swedish" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'swedish') { echo "selected";} ?> ><?php echo esc_html__('Swedish', 'wpchatbot'); ?></option>
					<option value="turkish" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'turkish') { echo "selected";} ?> ><?php echo esc_html__('Turkish', 'wpchatbot'); ?></option>
					<option value="ukrainian" <?php if (get_option('qlcd_wp_chatbot_stop_words_name') == 'ukrainian') { echo "selected";} ?> ><?php echo esc_html__('Ukrainian', 'wpchatbot'); ?></option>
				</select>
				<i></i>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row">StopWords</th>
			<td>
			
			<?php $englishStopwords = "a,able,about,above,abst,accordance,according,accordingly,across,act,actually,added,adj,affected,affecting,affects,after,afterwards,again,against,ah,all,almost,alone,along,already,also,although,always,am,among,amongst,an,and,announce,another,any,anybody,anyhow,anymore,anyone,anything,anyway,anyways,anywhere,apparently,approximately,are,aren,arent,arise,around,as,aside,ask,asking,at,auth,available,away,awfully,b,back,be,became,because,become,becomes,becoming,been,before,beforehand,begin,beginning,beginnings,begins,behind,being,believe,below,beside,besides,between,beyond,biol,both,brief,briefly,but,by,c,ca,came,can,cannot,can't,cause,causes,certain,certainly,co,com,come,comes,contain,containing,contains,could,couldnt,d,date,did,didn't,different,do,does,doesn't,doing,done,don't,down,downwards,due,during,e,each,ed,edu,effect,eg,eight,eighty,either,else,elsewhere,end,ending,enough,especially,et,et-al,etc,even,ever,every,everybody,everyone,everything,everywhere,ex,except,f,far,few,ff,fifth,first,five,fix,followed,following,follows,for,former,formerly,forth,found,four,from,further,furthermore,g,gave,get,gets,getting,give,given,gives,giving,go,goes,gone,got,gotten,h,had,happens,hardly,has,hasn't,have,haven't,having,he,hed,hence,her,here,hereafter,hereby,herein,heres,hereupon,hers,herself,hes,hi,hid,him,himself,his,hither,home,how,howbeit,however,hundred,i,id,ie,if,i'll,im,immediate,immediately,importance,important,in,inc,indeed,index,information,instead,into,invention,inward,is,isn't,it,itd,it'll,its,itself,i've,j,just,k,keep,keeps,kept,kg,km,know,known,knows,l,largely,last,lately,later,latter,latterly,least,less,lest,let,lets,like,liked,likely,line,little,'ll,look,looking,looks,ltd,m,made,mainly,make,makes,many,may,maybe,me,mean,means,meantime,meanwhile,merely,mg,might,million,miss,ml,more,moreover,most,mostly,mr,mrs,much,mug,must,my,myself,n,na,name,namely,nay,nd,near,nearly,necessarily,necessary,need,needs,neither,never,nevertheless,new,next,nine,ninety,no,nobody,non,none,nonetheless,noone,nor,normally,nos,not,noted,nothing,now,nowhere,o,obtain,obtained,obviously,of,off,often,oh,ok,okay,old,omitted,on,once,one,ones,only,onto,or,ord,other,others,otherwise,ought,our,ours,ourselves,out,outside,over,overall,owing,own,p,page,pages,part,particular,particularly,past,per,perhaps,placed,please,plus,poorly,possible,possibly,potentially,pp,predominantly,present,previously,primarily,probably,promptly,proud,provides,put,q,que,quickly,quite,qv,r,ran,rather,rd,re,readily,really,recent,recently,ref,refs,regarding,regardless,regards,related,relatively,research,respectively,resulted,resulting,results,right,run,s,said,same,saw,say,saying,says,sec,section,see,seeing,seem,seemed,seeming,seems,seen,self,selves,sent,seven,several,shall,she,shed,she'll,shes,should,shouldn't,show,showed,shown,showns,shows,significant,significantly,similar,similarly,since,six,slightly,so,some,somebody,somehow,someone,somethan,something,sometime,sometimes,somewhat,somewhere,soon,sorry,specifically,specified,specify,specifying,still,stop,strongly,sub,substantially,successfully,such,sufficiently,suggest,sup,sure,t,take,taken,taking,tell,tends,th,than,thank,thanks,thanx,that,that'll,thats,that've,the,their,theirs,them,themselves,then,thence,there,thereafter,thereby,thered,therefore,therein,there'll,thereof,therere,theres,thereto,thereupon,there've,these,they,theyd,they'll,theyre,they've,think,this,those,thou,though,thoughh,thousand,throug,through,throughout,thru,thus,til,tip,to,together,too,took,toward,towards,tried,tries,truly,try,trying,ts,twice,two,u,un,under,unfortunately,unless,unlike,unlikely,until,unto,up,upon,ups,us,use,used,useful,usefully,usefulness,uses,using,usually,v,value,various,'ve,very,via,viz,vol,vols,vs,w,want,wants,was,wasnt,way,we,wed,welcome,we'll,went,were,werent,we've,what,whatever,what'll,whats,when,whence,whenever,where,whereafter,whereas,whereby,wherein,wheres,whereupon,wherever,whether,which,while,whim,whither,who,whod,whoever,whole,who'll,whom,whomever,whos,whose,why,widely,willing,wish,with,within,without,wont,words,world,would,wouldnt,www,x,y,yes,yet,you,youd,you'll,your,youre,yours,yourself,yourselves,you've,z,zero";
                                                    ?>
			<i>Stop words will be excluded from user's search terms for better results. You can edit them from below.</i><br><br>
			<textarea id="qlcd_wp_chatbot_stop_words" cols="150" rows="10"
					  name="qlcd_wp_chatbot_stop_words"><?php echo(get_option('qlcd_wp_chatbot_stop_words') != '' ? str_replace('\\', '', get_option('qlcd_wp_chatbot_stop_words')) : $englishStopwords) ?> </textarea>
			
			</td>
		</tr>
		
	</table>
	<?php submit_button(); ?>
	</form>
</div>