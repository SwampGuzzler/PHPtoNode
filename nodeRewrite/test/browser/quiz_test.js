var expect = chai.expect; 

describe('Quiz object tests', function() {
  var quiz;

  beforeEach(function() {
    quiz = new Quiz('A test quiz');
  });

  describe('constructor', function() {

    it('quiz should be truthy (exists)', function() {
      expect(quiz).to.be.ok;
    });

    it('quiz should have title property', function() {
      expect(quiz).to.have.property('title');
    });

    it('quiz title property matches beforeEach', function() {
      expect(quiz.title).to.equal('A test quiz');
    });

  });
});