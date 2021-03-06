(function(){

  angular
      .module('codigo')
      .controller('codigo.core.article.articleListCtrl', ['pi.core.article.articleSvc', '$scope', '$stateParams', '$piEventStateEnum',
      function(articleSvc, $scope, $stateParams, $piEventStateEnum){
          baseListCtrl.call(this, $scope, $stateParams);
          var self = this;

          this.getData = function() {
            var model = self.getQueryModel(['name', 'categoryId']);
            model.state = $piEventStateEnum.Published;
            return articleSvc.find(model).then(function(r){
                return r.data.articles || r.data;
            }, function(){
                
            });
          }

      }]);
})();
