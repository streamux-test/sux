<? include "top.php"; ?>
	
	<div id="myVisual" class="visual-slide">
		<h2 class="blind">배너광고</h2>
		<ol id="indicator" class="indicator">
			<!-- templete
			<li data-target="#myVisual" data-slide-to="0"></li>
			-->
		</ol>
		<div id="inner" class="inner">        
			<div class="item" data-key="1">
				<span class="tt">Welcome!</span>
				<span class="stt">streamux.com</span>
			</div>
			<div class="item" data-key="2">
				<span class="tt">Now On Sale</span>
				<span class="stt">SUX BOARD For mobile</span>
			</div>
			<div class="item" data-key="3">
				<span class="tt">jSUX API</span>
				<span class="stt">For All Cross Platform</span>
			</div>
		</div>
	</div>
	<div class="container">	
		<div class="articles ui-edgebox">
			<div class="connect">
				<h2 class="blind">접속로그현황</h2> 
				<div class="tt">
					<div class="imgbox">
						<span>접속로그현황</span>  
					</div>        
				</div>  
				<div class="box">
					<table summary="접속로그현황 정보를 제공합니다.">
						<caption><span class="blind">접속로그현황</span></caption>
						<colgroup>
							<col width="45%">
							<col width="55%">
						</colgroup>
						<thead>
							<tr>
								<th scope="col">구분</th>
								<th scope="col">접속수</th>
							</tr>						
						</thead>
						<tbody>
							<tr>
								<td>오늘접속</td>
								<td id="today" class="view-type-textfield"></td>
							</tr>
							<tr>
								<td>어제접속</td>
								<td id="yester" class="view-type-textfield"></td>
							</tr>
							<tr>
								<td>전체접속</td>
								<td id="total" class="view-type-textfield"></td>
							</tr>
						</tbody>
					</table>
					<table summary="접속로그현황 정보를 제공합니다.">
						<caption><span class="blind">접속로그현황</span></caption>
						<colgroup>
							<col width="45%">
							<col width="55%">
						</colgroup>
						<thead>
							<tr>
								<th scope="col">구분</th>
								<th scope="col">접속수</th>
							</tr>						
						</thead>
						<tbody>
							<tr>
								<td>오늘 실접속</td>
								<td id="real_today" class="view-type-textfield"></td>
							</tr>
							<tr>
								<td>어제 실접속</td>
								<td id="real_yester" class="view-type-textfield"></td>
							</tr>
							<tr>
								<td>전체 실접속</td>
								<td id="real_total" class="view-type-textfield"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="ui-tab-promotion">
				<h2 class="blind">페이지 별 클릭 수와 접속경로 분석 탭</h2>
				<ui class="tab-header">					
					<li class="tt">
						<div class="imgbox-true">
							<span>페이지 별 클릭 수</span>
						</div>												
					</li>
					<li class="tt">
						<div class="imgbox-false">
							<span>접속경로 분석</span>
						</div>
					</li>
				</ui>
				<div class="pageview activate-false">       
					<table summary="페이지 별 클릭 수 정보를 제공합니다.">
						<caption><span class="blind">페이지 별 클릭 수</span></caption>
						<colgroup>
							<col width="12%">
							<col width="28%">
							<col width="20%">
							<col width="40%">
						</colgroup>
						<thead>
							<tr>
								<th scope="col" class="p-no">번호</th>
								<th scope="col" class="p-name">페이지 이름</th>
								<th scope="col" class="p-hit">클릭수</th>
								<th scope="col" class="p-graph">통계그래프</th>
							</tr>         
						</thead>
						<tbody id="articlesHitList">
							<!--
							@ jquery templete
							@ name	hitAnalysisWarnMsg_tmpl, hitAnalysisList_tmpl
							-->
							<tr>
								<td colspan="4"></td>
							</tr>
						</tbody>
					</table>
					<div class="ui-navi ui-navi-hide">
						<a href="#none"><span class="ui-navi-prev">이전</span></a>
						<ol id="hitNaviList" class="ui-navi-list">
							<!--
							@ templete boardNaviList_tmpl
							-->
						</ol>
						<a href="#none"><span class="ui-navi-next">다음</span></a>
					</div>
				</div>
				<div class="analysis activate-false">
					<table summary="접속경로 정보를 제공합니다.">
						<caption><span class="blind">접속경로분석</span></caption>
						<colgroup>
							<col width="12%">
							<col width="28%">
							<col width="20%">
							<col width="40%">
						</colgroup>
						<thead>
							<tr>
								<th scope="col">번호</th>
								<th scope="col" class="p-name">접속키워드</th>
								<th scope="col" class="p-hit">클릭수</th>
								<th scope="col" class="p-graph">통계그래프</th>
							</tr>         
						</thead>
						<tbody id="articlesAnalysisList">
							<!--
							@ jquery templete
							@ name	hitAnalysisWarnMsg_tmpl, hitAnalysisList_tmpl
							-->
							<tr>
								<td colspan="4"></td>
							</tr>
						</tbody>
					</table>
					<div class="ui-navi ui-navi-hide">
						<a href="#none"><span class="ui-navi-prev">이전</span></a>
						<ol id="analysisNaviList" class="ui-navi-list">
							<!--
							@ templete AnalysisNaviList_tmpl
							-->
						</ol>
						<a href="#none"><span class="ui-navi-next">다음</span></a>
					</div>
				</div>
			</div>
			<div class="config">
				<h2 class="blind">서비스 설정 상태</h2>
				<div class="tt">
					<div class="imgbox">
						<span>서비스 설정상태</span>
					</div>
				</div>
				<div class="box">
					<table summary="서비스 설정 상태정보를 제공합니다.">
						<caption><span class="hide">서비스 설정 상태</span></caption>
						<colgroup>
							<col width="27%">
							<col width="13%">
							<col width="10%">
							<col width="27%">
							<col width="13%">
							<col width="10%">
						</colgroup>
						<thead>
							<tr>
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>팝업등록</td>
								<td id="popupNum" class="view-type-textfield"></td>
								<td id="popupIcon" class="view-type-icon icon-inactivate"></td>
								<td>게시판등록</td>
								<td id="boardNum" class="view-type-textfield"></td>
								<td id="boardIcon" class="view-type-icon icon-inactivate"></td>
							</tr>
							<tr>
								<td>접속키워드등록</td>
								<td  id="analysisNum" class="view-type-textfield"></td>
								<td id="analysisIcon" class="view-type-icon icon-inactivate"></td>
								<td>그룹회원</td>
								<td id="memberNum" class="view-type-textfield"></td>
								<td id="memberIcon" class="view-type-icon icon-inactivate"></td>
							</tr>
							<tr>
								<td>페이지뷰등록</td>
								<td id="pageviewNum" class="view-type-textfield"></td>
								<td id="pageviewIcon" class="view-type-icon icon-inactivate"></td>
								<td colspan="3"></td>
							</tr>
						</tbody>
					</table>			
				</div>
			</div>
		</div>
	</div>	
</div>

<script type="x-jquery-templete" id="textfield_tmpl">
	<span>${$item.getUnit( label )}</span>
</script>

<script type="x-jquery-templete" id="hitAnalysisWarnMsg_tmpl">
	<tr>
		<td colspan="4" style="border-bottom-style:none"><span class="warn-msg">${msg}</span></td>
	</tr>
</script>

<script type="x-jquery-templete" id="hitAnalysisList_tmpl">
	<tr>
		<td class="p-no">${no}</td>
		<td class="p-name">${name}</td>
		<td class="p-hit">${hit}회</td>
		<td class="p-graph"><div class="g-graph"></div><span>0%</span></td>
	</tr>
</script>

<script type="x-jquery-templete" id="NaviList_tmpl">
	<li><a href="#none"><span>${no}</span></a></li>
</script>

<script type="text/javascript" src="../../common/js/navi.min.js"></script>
<script type="text/javascript" src="./tpl/js/main.js"></script>

<? include "bottom.php"; ?>