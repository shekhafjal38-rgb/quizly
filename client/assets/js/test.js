document.addEventListener('DOMContentLoaded',function(){
  const qArea = document.getElementById('questionArea');
  const timeEl = document.getElementById('time');
  let index = 0; const answers = {};
  function render() {
    const q = QUESTIONS[index];
    qArea.innerHTML = '';
    const h = document.createElement('h3'); h.textContent = 'Q'+(index+1)+'. '+q.question_text; qArea.appendChild(h);
    const opts = document.createElement('div'); opts.className='options';
    ['a','b','c','d'].forEach(function(k){
      const btn = document.createElement('button'); btn.type='button'; btn.innerHTML = '<strong>'+k.toUpperCase()+'.</strong> '+q['option_'+k];
      btn.addEventListener('click',function(){
        Array.from(opts.children).forEach(b=>b.classList.add('disabled'));
        btn.classList.remove('disabled'); btn.dataset.selected='1';
        answers[q.id]=k;
      });
      opts.appendChild(btn);
    });
    qArea.appendChild(opts);
    if (answers[q.id]){
      Array.from(opts.children).forEach(b=>{ if (b.textContent.trim().toLowerCase().startsWith(answers[q.id])){ b.classList.remove('disabled'); } else b.classList.add('disabled'); });
    }
    document.getElementById('prevBtn').disabled = index===0;
    document.getElementById('submitBtn').style.display = (index===QUESTIONS.length-1)?'inline-block':'none';
  }
  document.getElementById('nextBtn').addEventListener('click',function(){ if (index<QUESTIONS.length-1){ index++; render(); } });
  document.getElementById('prevBtn').addEventListener('click',function(){ if (index>0){ index--; render(); } });
  let secs = 0; const timer = setInterval(()=>{ secs++; timeEl.textContent = secs; },1000);
  document.getElementById('testForm').addEventListener('submit',function(e){
    e.preventDefault();
    for (let qid in answers){ const inp = document.createElement('input'); inp.type='hidden'; inp.name='answers['+qid+']'; inp.value=answers[qid]; document.getElementById('testForm').appendChild(inp); }
    document.getElementById('start_ts').value = START_TS;
    clearInterval(timer);
    e.target.submit();
  });
  render();
});
